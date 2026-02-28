<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\User;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getMe method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getme
 *
 * @implements TelegramMethod<array<string, array{
 *   id: int,
 *   is_bot: bool,
 *   first_name: string,
 *   last_name?: string,
 *   username?: string,
 *   language_code?: string,
 *   can_join_groups?: bool,
 *   can_read_all_group_messages?: bool,
 *   supports_inline_queries?: bool
 * }>>
 */
final class GetMe implements TelegramMethod
{
    public function __construct() {}

    public function getMethod(): string
    {
        return 'getMe';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @param array{ok: bool, result: array{
     *   id: int,
     *   is_bot: bool,
     *   first_name: string,
     *   last_name?: string,
     *   username?: string,
     *   language_code?: string,
     *   can_join_groups?: bool,
     *   can_read_all_group_messages?: bool,
     *   supports_inline_queries?: bool
     * }} $result
     *
     * @return array<string, array{
     *   id: int,
     *   is_bot: bool,
     *   first_name: string,
     *   last_name?: string,
     *   username?: string,
     *   language_code?: string,
     *   can_join_groups?: bool,
     *   can_read_all_group_messages?: bool,
     *   supports_inline_queries?: bool
     * }>
     */
    public function mapResponse(array $result): array
    {
        // Wrap the user object in an associative array to match the expected return type
        return ['user' => $result['result']];
    }
}
