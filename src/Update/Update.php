<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Update;

use Aymericcucherousset\TelegramBot\Value\ChatId;

final readonly class Update
{
    public function __construct(
        public int $id,
        public ?Message $message = null,
        public ?CallbackQuery $callbackQuery = null,
        public ?string $type = null
    ) {}

    public function isCommand(): bool
    {
        return $this->message?->isCommand() ?? false;
    }

    public function commandName(): string
    {
        return $this->message?->commandName() ?? '';
    }

    /**
     * @return string[]
     */
    public function commandArguments(): array
    {
        return $this->message?->commandArguments() ?? [];
    }

    public function isMessage(): bool
    {
        return null !== $this->message;
    }

    public function isCallbackQuery(): bool
    {
        return null !== $this->callbackQuery;
    }

    public function chatId(): ChatId
    {
        if ($this->isMessage()) {
            return $this->message->chatId ?? throw new \LogicException('Message does not contain a chat.');
        }

        if ($this->isCallbackQuery()) {
            return $this->callbackQuery->chatId ?? throw new \LogicException('CallbackQuery does not contain a chat.');
        }

        throw new \LogicException('Update does not contain a chat.');
    }
}
