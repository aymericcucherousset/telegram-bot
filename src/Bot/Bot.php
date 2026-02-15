<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Bot;

use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Registry\HandlerRegistry;
use Aymericcucherousset\TelegramBot\Update\Update;

final class Bot
{
    public function __construct(
        private TelegramClientInterface $client,
        private HandlerRegistry $handlers = new HandlerRegistry(),
    ) {}

    public function getClient(): TelegramClientInterface
    {
        return $this->client;
    }

    public function onCommand(string $name, HandlerInterface $handler): void
    {
        $this->handlers->register($name, $handler);
    }

    public function handle(Update $update): void
    {
        if ($update->isCommand() || $update->isCallbackQuery()) {
            $this->handlers->dispatch($update);
        }
    }
}
