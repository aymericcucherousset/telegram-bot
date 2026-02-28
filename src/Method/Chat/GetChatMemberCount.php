<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getChatMemberCount method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getchatmembercount
 *
 * @implements TelegramMethod<array<string, int>>
 */
final class GetChatMemberCount implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target supergroup or channel
     */
    public function __construct(
        private readonly ChatId $chatId,
    ) {}

    public function getMethod(): string
    {
        return 'getChatMemberCount';
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
     * @param array{ok: bool, result: int} $result
     *
     * @return array<string, int>
     */
    public function mapResponse(array $result): array
    {
        // Wrap the count in an associative array to match the expected return type
        return ['count' => $result['result']];
    }
}