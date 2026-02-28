<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the unbanChatMember method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#unbanchatmember
 *
 * @implements TelegramMethod<bool>
 */
final class UnbanChatMember implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target supergroup or channel
     * @param int $userId Unique identifier of the target user
     * @param bool|null $onlyIfBanned Do nothing if the user is not banned
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly int $userId,
        private readonly ?bool $onlyIfBanned = null,
    ) {}

    public function getMethod(): string
    {
        return 'unbanChatMember';
    }

    /**
     * @return array{chat_id: int|string, user_id: int, only_if_banned?: bool}
     */
    public function toArray(): array
    {
        return array_filter([
            'chat_id' => $this->chatId->value(),
            'user_id' => $this->userId,
            'only_if_banned' => $this->onlyIfBanned,
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
