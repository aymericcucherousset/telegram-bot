<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the deleteMessage method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#deletemessage
 *
 * @implements TelegramMethod<bool>
 */
final class DeleteMessage implements TelegramMethod
{
    public function __construct(
        private readonly ChatId $chatId,
        private readonly int $messageId,
    ) {}

    public function getMethod(): string
    {
        return 'deleteMessage';
    }

    /**
     * @return array{chat_id: int|string, message_id: int}
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId->value(),
            'message_id' => $this->messageId,
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
