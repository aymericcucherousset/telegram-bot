<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the deleteChatPhoto method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#deletechatphoto
 *
 * @implements TelegramMethod<bool>
 */
final class DeleteChatPhoto implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     */
    public function __construct(
        private readonly ChatId $chatId,
    ) {}

    public function getMethod(): string
    {
        return 'deleteChatPhoto';
    }

    /**
     * @return array{chat_id: int|string}
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId->value(),
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
