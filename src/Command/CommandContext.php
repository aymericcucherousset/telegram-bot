<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Command;

use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;

final readonly class CommandContext
{
    public function __construct(
        public Update $update,
        public TelegramClientInterface $client
    ) {}
}
