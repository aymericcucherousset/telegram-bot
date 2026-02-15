<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface as PsrRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Aymericcucherousset\TelegramBot\Exception\ApiException;

final class HttpTelegramClient implements TelegramClientInterface
{
    private const string API_BASE = 'https://api.telegram.org/bot';

    /**
     * Accepts either:
     *   - $requestFactory: an instance of RequestFactoryInterface (custom or adapter)
     *   - $requestFactory: a PSR-17 RequestFactoryInterface, and $streamFactory: a PSR-17 StreamFactoryInterface
     */
    private RequestFactoryInterface $requestFactory;

    public function __construct(
        private ClientInterface $httpClient,
        RequestFactoryInterface|PsrRequestFactoryInterface $requestFactory,
        private string $token,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        if ($requestFactory instanceof PsrRequestFactoryInterface) {
            if (!$streamFactory) {
                throw new \InvalidArgumentException('StreamFactoryInterface is required when using PSR-17 RequestFactoryInterface');
            }
            $this->requestFactory = new PsrRequestFactoryAdapter($requestFactory, $streamFactory);
        } else {
            $this->requestFactory = $requestFactory;
        }
    }

    /**
     * @template TResponse
     * @param TelegramMethod<TResponse> $method
     * @return TResponse
     */
    public function send(TelegramMethod $method): mixed
    {
        $response = $this->request(
            method: $method->getMethod(),
            payload: $method->toArray()
        );

        return $method->mapResponse($response);
    }

    /**
     * @param mixed[] $payload
     *
     * @return array<string, mixed> The 'result' field from the Telegram API response.
     */
    private function request(string $method, array $payload): array
    {
        $request = $this->requestFactory->create(
            'POST',
            self::API_BASE . $this->token . '/' . $method,
            ['Content-Type' => 'application/json'],
            json_encode($payload, JSON_THROW_ON_ERROR)
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new ApiException(
                'HTTP error while calling Telegram API.',
                previous: $e
            );
        }

        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();

        if ($statusCode !== 200) {
            throw new ApiException(
                \sprintf('Telegram API returned HTTP %d: %s', $statusCode, $body)
            );
        }

        $data = json_decode($body, true);

        if (!\is_array($data) || !($data['ok'] ?? false)) {
            $description = 'Unknown Telegram API error';

            if (\is_array($data) && isset($data['description']) && \is_string($data['description'])) {
                $description = $data['description'];
            }

            throw new ApiException(
                'Telegram API error: ' . $description
            );
        }

        /** @var array<string, mixed> $data */
        return $data;
    }
}
