<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Command;

use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;

final class CommandRegistry implements CommandRegistryInterface
{
    /**
     * @var array<string, CommandInterface>
     */
    private array $commands = [];

    public function register(string $name, CommandInterface $command): void
    {
        $this->commands[$name] = $command;
    }

    public function dispatch(Update $update, TelegramClientInterface $client): void
    {
        if (!$update->isCommand()) {
            return;
        }
        $command = $update->commandName();
        if (!isset($this->commands[$command])) {
            return;
        }
        $this->commands[$command]->handle(
            new CommandContext($update, $client)
        );
    }
}
