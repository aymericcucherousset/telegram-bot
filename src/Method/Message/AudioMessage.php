<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the sendAudio method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#sendaudio
 *
 * @implements TelegramMethod<bool>
 */
final class AudioMessage implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param string $audio Path to audio file, URL, or file resource
     * @param string|null $caption
     * @param string|null $performer
     * @param string|null $title
     * @param int|null $duration
     * @param InlineKeyboardMarkup|null $keyboard
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $audio,
        private readonly ?string $caption = null,
        private readonly ?string $performer = null,
        private readonly ?string $title = null,
        private readonly ?int $duration = null,
        private readonly ?InlineKeyboardMarkup $keyboard = null,
    ) {}

    public function getMethod(): string
    {
        return 'sendAudio';
    }

    /**
     * @return array{
     *  chat_id: int|string,
     *  audio: string|resource,
     *  caption?: string,
     *  performer?: string,
     *  title?: string,
     *  duration?: int,
     *  reply_markup?: array{
     *      inline_keyboard: array<array<array{
     *          text?: non-falsy-string,
     *          callback_data?: non-falsy-string,
     *          url?: non-falsy-string
     *      }>>
     *  }
     *}
     */
    public function toArray(): array
    {
        $isLocalFile = !str_contains($this->audio, 'http://') && !str_contains($this->audio, 'https://') && file_exists($this->audio);
        $audio = $isLocalFile ? fopen($this->audio, 'r') : $this->audio;
        if (false === $audio) {
            throw new \RuntimeException("Failed to open local file: {$this->audio}");
        }
        $payload = [
            'chat_id' => $this->chatId->value(),
            'audio' => $audio,
        ];
        if ($this->caption) {
            $payload['caption'] = $this->caption;
        }
        if ($this->performer) {
            $payload['performer'] = $this->performer;
        }
        if ($this->title) {
            $payload['title'] = $this->title;
        }
        if ($this->duration) {
            $payload['duration'] = $this->duration;
        }
        if ($this->keyboard) {
            $payload['reply_markup'] = $this->keyboard->toArray();
        }
        return $payload;
    }

    /**
    * @param array{ok: bool} $result
    *
    * @return bool
    */
    public function mapResponse(array $result): bool
    {
        return $result['ok'];
    }
}
