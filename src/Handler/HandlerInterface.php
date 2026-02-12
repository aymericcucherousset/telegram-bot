<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Handler;

use Aymericcucherousset\TelegramBot\Update\Update;

interface HandlerInterface
{
    public function handle(Update $update): void;
}
