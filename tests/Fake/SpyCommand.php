<?php

declare(strict_types=1);

namespace Tests\Fake;

use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;

class SpyCommand implements HandlerInterface
{
    public bool $called = false;
    public function handle(Update $update): void
    {
        $this->called = true;
    }
}
