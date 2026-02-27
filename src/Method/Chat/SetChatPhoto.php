<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setChatPhoto method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setchatphoto
 *
 * @implements TelegramMethod<bool>
 */
final class SetChatPhoto implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param string $photo Path to photo, URL, or file resource
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $photo,
    ) {}

    public function getMethod(): string
    {
        return 'setChatPhoto';
    }

    /**
     * @return array{chat_id: int|string, photo: string|resource}
     */
    public function toArray(): array
    {
        $isLocalFile = !str_contains($this->photo, 'http://') && !str_contains($this->photo, 'https://') && file_exists($this->photo);
        $photo = $isLocalFile ? fopen($this->photo, 'r') : $this->photo;
        if (false === $photo) {
            throw new \RuntimeException("Failed to open local file: {$this->photo}");
        }
        return [
            'chat_id' => $this->chatId->value(),
            'photo' => $photo,
        ];
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
