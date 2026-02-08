<?php

declare(strict_types=1);

namespace Tests\Fake;

use Aymericcucherousset\TelegramBot\Command\CommandInterface;
use Aymericcucherousset\TelegramBot\Command\CommandContext;

class SpyCommand implements CommandInterface
{
    public bool $called = false;
    public function handle(CommandContext $context): void
    {
        $this->called = true;
    }
}
