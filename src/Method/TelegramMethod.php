<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method;

/**
 * TelegramMethod defines the contract for all Telegram API method objects.
 * Each implementation must provide the API method name and the payload array.
 *
 * @template TResponse The expected type of the response after mapping the Telegram API result.
 */
interface TelegramMethod
{
    /**
     * Returns the payload to send to the Telegram API.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Returns the Telegram API method name (e.g., 'sendMessage').
     */
    public function getMethod(): string;

    /**
     * Maps the Telegram API response to the expected return type.
     *
     * @param array<string, mixed> $result The 'result' field from the Telegram API response.
     *
     * @return TResponse The mapped response, which can be of any type depending on the method.
     */
    public function mapResponse(array $result): mixed;
}
