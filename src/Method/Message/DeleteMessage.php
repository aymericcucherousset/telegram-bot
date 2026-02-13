<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

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
}
