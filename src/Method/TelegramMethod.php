<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method;

/**
 * TelegramMethod defines the contract for all Telegram API method objects.
 * Each implementation must provide the API method name and the payload array.
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
}
