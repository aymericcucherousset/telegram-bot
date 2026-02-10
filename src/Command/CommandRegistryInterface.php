<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Command;

interface CommandRegistryInterface
{
    public function register(string $name, CommandInterface $command): void;
}
