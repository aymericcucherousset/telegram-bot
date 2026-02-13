<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Aymericcucherousset\TelegramBot\Message\OutboundMessageInterface;

interface TelegramClientInterface
{
    public function send(OutboundMessageInterface $message): void;
}
