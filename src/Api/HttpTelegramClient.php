<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\ParseMode;
use Aymericcucherousset\TelegramBot\Exception\ApiException;
use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;

final class HttpTelegramClient implements TelegramClientInterface
{
    private const API_BASE = 'https://api.telegram.org/bot';

    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private string $token
    ) {}

    public function sendMessage(
        ChatId $chatId,
        string $text,
        ParseMode $mode = ParseMode::Plain,
        ?InlineKeyboardMarkup $keyboard = null
    ): void {
        $payload = [
            'chat_id' => (string) $chatId,
            'text' => $text,
        ];

        if ($mode->telegramValue() !== null) {
            $payload['parse_mode'] = $mode->telegramValue();
        }

        if ($keyboard !== null) {
            $payload['reply_markup'] = $keyboard->toArray();
        }

        $request = $this->requestFactory->create(
            'POST',
            self::API_BASE . $this->token . '/sendMessage',
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
