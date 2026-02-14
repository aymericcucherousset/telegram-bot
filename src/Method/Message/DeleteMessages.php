<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the deleteMessages method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#deletemessages
 *
 * @implements TelegramMethod<bool>
 */
final class DeleteMessages implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param int[] $messageIds
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly array $messageIds,
    ) {}

    public function getMethod(): string
    {
        return 'deleteMessages';
    }

    /**
     * @return array{chat_id: int|string, message_ids: int[]}
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId->value(),
            'message_ids' => $this->messageIds,
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
