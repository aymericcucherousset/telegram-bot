<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Psr\Http\Message\RequestFactoryInterface as PsrRequestFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestInterface;

final class PsrRequestFactoryAdapter implements RequestFactoryInterface
{
    public function __construct(
        private PsrRequestFactory $requestFactory,
        private StreamFactoryInterface $streamFactory
    ) {}

    /**
     * @param array<string, string> $headers
     */
    public function create(
        string $method,
        string $uri,
        array $headers = [],
        string $body = ''
    ): RequestInterface {
        $request = $this->requestFactory->createRequest($method, $uri);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($body !== '') {
            $stream = $this->streamFactory->createStream($body);
            $request = $request->withBody($stream);
        }

        return $request;
    }
}
