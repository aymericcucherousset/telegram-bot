<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

interface TelegramClientInterface
{
    public function send(TelegramMethod $message): void;
}
