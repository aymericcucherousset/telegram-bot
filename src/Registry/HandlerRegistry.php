<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Registry;

use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;

final class HandlerRegistry implements HandlerRegistryInterface
{
    /**
     * @var array<string, HandlerInterface>
     */
    private array $handlers = [];

    public function register(string $name, HandlerInterface $handler): void
    {
        $this->handlers[$name] = $handler;
    }

    public function dispatch(Update $update): void
    {
        match ($update->type) {
            'message' => $this->handleMessage($update),
            'callback_query' => $this->handleCallbackQuery($update),
            default => null,
        };
    }

    private function handleMessage(Update $update): void
    {
        if (!$update->message) {
            return;
        }
        if (!$update->message->isCommand()) {
            return;
        }
        $handler = $update->message->commandName();
        if (!isset($this->handlers[$handler])) {
            return;
        }

        $this->handlers[$handler]->handle($update);
    }

    private function handleCallbackQuery(Update $update): void
    {
        if (!$update->callbackQuery) {
            return;
        }
        if (!$update->callbackQuery->data) {
            return;
        }
        $handler = $update->callbackQuery->data;
        if (!isset($this->handlers[$handler])) {
            return;
        }
        $this->handlers[$handler]->handle($update);
    }
}
