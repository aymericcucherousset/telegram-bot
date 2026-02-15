<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Registry;

use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Update\Update;

interface HandlerRegistryInterface
{
    public function register(string $name, HandlerInterface $handler): void;

    public function dispatch(Update $update): void;
}
