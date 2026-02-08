<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Bot;

use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Command\CommandRegistry;
use Aymericcucherousset\TelegramBot\Command\CommandInterface;
use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;

final class Bot
{
    public function __construct(
        private TelegramClientInterface $client,
        private CommandRegistry $commands = new CommandRegistry()
    ) {}

    public function onCommand(string $name, CommandInterface $command): void
    {
        $this->commands->register($name, $command);
    }

    public function handle(Update $update): void
    {
        if ($update->isCommand()) {
            $this->commands->dispatch($update, $this->client);
        }
    }
}
