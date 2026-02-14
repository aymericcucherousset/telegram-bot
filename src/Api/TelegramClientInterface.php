<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

interface TelegramClientInterface
{
    /**
     * @template TResponse
     * @param TelegramMethod<TResponse> $method
     * @return TResponse
     */
    public function send(TelegramMethod $method): mixed;
}
