<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Update;

final readonly class Update
{
    public function __construct(
        public int $id,
        public ?Message $message = null
    ) {}

    public function isCommand(): bool
    {
        return $this->message?->isCommand() ?? false;
    }

    public function commandName(): string
    {
        return $this->message?->commandName() ?? '';
    }
}
