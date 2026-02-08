<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Psr\Http\Message\RequestInterface;

interface RequestFactoryInterface
{
    /**
     * Create a PSR-7 compliant HTTP request.
     *
     * @param array<string, string> $headers
     */
    public function create(
        string $method,
        string $uri,
        array $headers = [],
        string $body = ''
    ): RequestInterface;
}
