<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the sendVideo method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#sendvideo
 *
 * @implements TelegramMethod<bool>
 */
final class VideoMessage implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param string $video Path to video, URL, or file resource
     * @param string|null $caption
     * @param int|null $duration Duration of sent video in seconds
     * @param int|null $width Video width
     * @param int|null $height Video height
     * @param string|null $thumb Thumbnail file path, URL, or file_id
     * @param bool|null $supportsStreaming
     * @param InlineKeyboardMarkup|null $keyboard
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $video,
        private readonly ?string $caption = null,
        private readonly ?int $duration = null,
        private readonly ?int $width = null,
        private readonly ?int $height = null,
        private readonly ?string $thumb = null,
        private readonly ?bool $supportsStreaming = null,
        private readonly ?InlineKeyboardMarkup $keyboard = null,
    ) {}

    public function getMethod(): string
    {
        return 'sendVideo';
    }

    /**
     * @return array{chat_id: int|string, video: string|resource, caption?: string, duration?: int, width?: int, height?: int, thumb?: string|resource, supports_streaming?: bool, reply_markup?: array{inline_keyboard: array<array<array{text?: non-falsy-string, callback_data?: non-falsy-string, url?: non-falsy-string}>>}}
     */
    public function toArray(): array
    {
        $isLocalFile = !str_contains($this->video, 'http://') && !str_contains($this->video, 'https://') && file_exists($this->video);
        $video = $isLocalFile ? fopen($this->video, 'r') : $this->video;
        if (false === $video) {
            throw new \RuntimeException("Failed to open local file: {$this->video}");
        }
        $payload = [
            'chat_id' => $this->chatId->value(),
            'video' => $video,
        ];
        if ($this->caption) {
            $payload['caption'] = $this->caption;
        }
        if ($this->duration) {
            $payload['duration'] = $this->duration;
        }
        if ($this->width) {
            $payload['width'] = $this->width;
        }
        if ($this->height) {
            $payload['height'] = $this->height;
        }
        if ($this->thumb) {
            $isThumbLocal = !str_contains($this->thumb, 'http://') && !str_contains($this->thumb, 'https://') && file_exists($this->thumb);
            $thumb = $isThumbLocal ? fopen($this->thumb, 'r') : $this->thumb;
            if (false === $thumb) {
                throw new \RuntimeException("Failed to open local file: {$this->thumb}");
            }
            $payload['thumb'] = $thumb;
        }
        if ($this->supportsStreaming !== null) {
            $payload['supports_streaming'] = $this->supportsStreaming;
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
