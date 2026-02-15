<?php

declare(strict_types=1);

namespace TelegramBot\Method\Webhook;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getWebhookInfo method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getwebhookinfo
 *
 * @implements TelegramMethod<array{
 *  url: string,
 *  has_custom_certificate: bool,
 *  pending_update_count: int,
 *  ip_address?: string,
 *  last_error_date?: int,
 *  last_error_message?: string,
 *  max_connections?: int,
 *  allowed_updates?: string[]
 * }>
 */
class WebhookInfo implements TelegramMethod
{
    public function getMethod(): string
    {
        return 'getWebhookInfo';
    }

    public function toArray(): array
    {
        // getWebhookInfo takes no parameters
        return [];
    }

    /**
     * @param array{
     *  ok: bool,
     *  result: array{
     *      url: string,
     *      has_custom_certificate: bool,
     *      pending_update_count: int,
     *      ip_address?: string,
     *      last_error_date?: int,
     *      last_error_message?: string,
     *      max_connections?: int,
     *      allowed_updates?: string[]
     *  }
     * } $result
     *
     * @return array{
     *  url: string,
     *  has_custom_certificate: bool,
     *  pending_update_count: int,
     *  ip_address?: string,
     *  last_error_date?: int,
     *  last_error_message?: string,
     *  max_connections?: int,
     *  allowed_updates?: string[]
     * }
     */
    public function mapResponse(array $result): array
    {
        return $result['result'];
    }
}
