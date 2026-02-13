<?php

declare(strict_types=1);

namespace Tests\Fake;

use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;

class FakeTelegramClient implements TelegramClientInterface
{
    public function send(\Aymericcucherousset\TelegramBot\Message\OutboundMessageInterface $message): void {}
}
