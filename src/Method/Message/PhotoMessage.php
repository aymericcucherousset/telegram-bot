<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the sendPhoto method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#sendphoto
 *
 * @implements TelegramMethod<bool>
 */
final class PhotoMessage implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param string $photo Path to photo, URL, or file resource
     * @param string|null $caption
     * @param InlineKeyboardMarkup|null $keyboard
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $photo,
        private readonly ?string $caption = null,
        private readonly ?InlineKeyboardMarkup $keyboard = null,
    ) {}

    public function getMethod(): string
    {
        return 'sendPhoto';
    }

    /**
     * @return array{chat_id: int|string, photo: string|resource, caption?: string, reply_markup?: array{inline_keyboard: array<array<array{text?: non-falsy-string, callback_data?: non-falsy-string, url?: non-falsy-string}>>}}
     */
    public function toArray(): array
    {
        $isLocalFile = !str_contains($this->photo, 'http://') && !str_contains($this->photo, 'https://') && file_exists($this->photo);

        // Convert local file path to resource if it's a local file, otherwise use the string (URL or file_id)
        $photo = $isLocalFile ? fopen($this->photo, 'r') : $this->photo;

        if (false === $photo) {
            throw new \RuntimeException("Failed to open local file: {$this->photo}");
        }

        $payload = [
            'chat_id' => $this->chatId->value(),
            'photo' => $photo,
        ];

        if ($this->caption) {
            $payload['caption'] = $this->caption;
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
