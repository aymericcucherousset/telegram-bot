<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Command;

interface CommandInterface
{
    public function handle(CommandContext $context): void;
}
