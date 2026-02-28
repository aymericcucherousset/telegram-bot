<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the leaveChat method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#leavechat
 *
 * @implements TelegramMethod<bool>
 */
final class LeaveChat implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target supergroup or channel
     */
    public function __construct(
        private readonly ChatId $chatId,
    ) {}

    public function getMethod(): string
    {
        return 'leaveChat';
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
