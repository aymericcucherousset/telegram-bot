<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Message;

use Aymericcucherousset\TelegramBot\Value\ChatId;

final class DeleteMessages implements OutboundMessageInterface
{
    /**
     * @param ChatId $chatId
     * @param int[] $messageIds
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly array $messageIds,
    ) {}

    public function method(): string
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
}
