<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Message;

use Aymericcucherousset\TelegramBot\Value\ChatId;

final class DeleteMessage implements OutboundMessageInterface
{
    public function __construct(
        private readonly ChatId $chatId,
        private readonly int $messageId,
    ) {}

    public function method(): string
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
