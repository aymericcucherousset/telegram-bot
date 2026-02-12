<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Registry;

use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;

interface HandlerRegistryInterface
{
    public function register(string $name, HandlerInterface $handler): void;
}
