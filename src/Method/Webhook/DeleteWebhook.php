<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Webhook;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the deleteWebhook method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#deletewebhook
 *
 * @implements TelegramMethod<bool>
 */
final class DeleteWebhook implements TelegramMethod
{
    public function __construct(
        private readonly ?bool $dropPendingUpdates = null,
    ) {}

    public function getMethod(): string
    {
        return 'deleteWebhook';
    }

    /**
     * @return array{drop_pending_updates?: bool}
     */
    public function toArray(): array
    {
        return array_filter([
            'drop_pending_updates' => $this->dropPendingUpdates,
        ], static fn($v) => $v !== null);
    }

    /**
     * @param array{ok: bool} $result
     *
     * @return bool
     */
    public function mapResponse(array $result): bool
    {
        return $result['ok'];
    }
}
