<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setChatTitle method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setchattitle
 *
 * @implements TelegramMethod<bool>
 */
final class SetChatTitle implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param string $title New chat title, 1-128 characters
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $title,
    ) {}

    public function getMethod(): string
    {
        return 'setChatTitle';
    }

    /**
     * @return array{chat_id: int|string, title: string}
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId->value(),
            'title' => $this->title,
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
