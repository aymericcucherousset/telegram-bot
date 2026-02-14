<?php

declare(strict_types=1);

namespace Tests\Fake;

use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

class FakeTelegramClient implements TelegramClientInterface
{
    public function send(TelegramMethod $method): mixed
    {
        return $method->mapResponse([
            'ok' => true,
        ]);
    }
}
