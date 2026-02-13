<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Aymericcucherousset\TelegramBot\Exception\ApiException;
use Aymericcucherousset\TelegramBot\Message\OutboundMessageInterface;

final class HttpTelegramClient implements TelegramClientInterface
{
    private const API_BASE = 'https://api.telegram.org/bot';

    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private string $token
    ) {}

    public function send(OutboundMessageInterface $message): void
    {
        $this->request(
            $message->method(),
            $message->toArray()
        );
    }

    /**
     * @param mixed[] $payload
     */
    private function request(string $method, array $payload): void
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
    }
}
