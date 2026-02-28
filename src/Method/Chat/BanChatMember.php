<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the banChatMember method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#banchatmember
 *
 * @implements TelegramMethod<bool>
 */
final class BanChatMember implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target supergroup or channel
     * @param int $userId Unique identifier of the target user
     * @param int|null $untilDate Date when the user will be unbanned, unix time. If 0 or not set, user is banned forever
     * @param bool|null $revokeMessages Pass true to delete all messages from the user in the chat
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly int $userId,
        private readonly ?int $untilDate = null,
        private readonly ?bool $revokeMessages = null,
    ) {}

    public function getMethod(): string
    {
        return 'banChatMember';
    }

    /**
     * @return array{chat_id: int|string, user_id: int, until_date?: int, revoke_messages?: bool}
     */
    public function toArray(): array
    {
        return array_filter([
            'chat_id' => $this->chatId->value(),
            'user_id' => $this->userId,
            'until_date' => $this->untilDate,
            'revoke_messages' => $this->revokeMessages,
        ], static fn($v) => $v !== null);
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
