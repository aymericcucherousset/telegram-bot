<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setChatDescription method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setchatdescription
 *
 * @implements TelegramMethod<bool>
 */
final class SetChatDescription implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param string|null $description New chat description, 0-255 characters
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly ?string $description,
    ) {}

    public function getMethod(): string
    {
        return 'setChatDescription';
    }

    /**
     * @return array{chat_id: int|string, description: string|null}
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId->value(),
            'description' => $this->description,
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
