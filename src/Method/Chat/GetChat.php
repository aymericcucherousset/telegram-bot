<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getChat method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getchat
 *
 * @implements TelegramMethod<array<string, array{
 *   id: int,
 *   type: string,
 *   title?: string,
 *   username?: string,
 *   first_name?: string,
 *   last_name?: string,
 *   is_forum?: bool,
 *   photo?: array<string, mixed>,
 *   active_usernames?: array<int, string>,
 *   emoji_status_custom_emoji_id?: string,
 *   bio?: string,
 *   has_private_forwards?: bool,
 *   has_restricted_voice_and_video_messages?: bool,
 *   join_to_send_messages?: bool,
 *   join_by_request?: bool,
 *   description?: string,
 *   invite_link?: string,
 *   pinned_message?: array<string, mixed>,
 *   permissions?: array<string, mixed>,
 *   slow_mode_delay?: int,
 *   unrestrict_boost_count?: int,
 *   message_auto_delete_time?: int,
 *   has_aggressive_anti_spam_enabled?: bool,
 *   has_hidden_members?: bool,
 *   has_protected_content?: bool,
 *   sticker_set_name?: string,
 *   can_set_sticker_set?: bool,
 *   linked_chat_id?: int,
 *   location?: array<string, mixed>
 * }>>
 */
final class GetChat implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target supergroup or channel
     */
    public function __construct(
        private readonly ChatId $chatId,
    ) {}

    public function getMethod(): string
    {
        return 'getChat';
    }

    /**
     * @return array{chat_id: int|string}
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId->value(),
        ];
    }

    /**
     * @param array{ok: bool, result: array{
     *   id: int,
     *   type: string,
     *   title?: string,
     *   username?: string,
     *   first_name?: string,
     *   last_name?: string,
     *   is_forum?: bool,
     *   photo?: array<string, mixed>,
     *   active_usernames?: array<int, string>,
     *   emoji_status_custom_emoji_id?: string,
     *   bio?: string,
     *   has_private_forwards?: bool,
     *   has_restricted_voice_and_video_messages?: bool,
     *   join_to_send_messages?: bool,
     *   join_by_request?: bool,
     *   description?: string,
     *   invite_link?: string,
     *   pinned_message?: array<string, mixed>,
     *   permissions?: array<string, mixed>,
     *   slow_mode_delay?: int,
     *   unrestrict_boost_count?: int,
     *   message_auto_delete_time?: int,
     *   has_aggressive_anti_spam_enabled?: bool,
     *   has_hidden_members?: bool,
     *   has_protected_content?: bool,
     *   sticker_set_name?: string,
     *   can_set_sticker_set?: bool,
     *   linked_chat_id?: int,
     *   location?: array<string, mixed>
     * }} $result
     *
     * @return array<string, array{
     *   id: int,
     *   type: string,
     *   title?: string,
     *   username?: string,
     *   first_name?: string,
     *   last_name?: string,
     *   is_forum?: bool,
     *   photo?: array<string, mixed>,
     *   active_usernames?: array<int, string>,
     *   emoji_status_custom_emoji_id?: string,
     *   bio?: string,
     *   has_private_forwards?: bool,
     *   has_restricted_voice_and_video_messages?: bool,
     *   join_to_send_messages?: bool,
     *   join_by_request?: bool,
     *   description?: string,
     *   invite_link?: string,
     *   pinned_message?: array<string, mixed>,
     *   permissions?: array<string, mixed>,
     *   slow_mode_delay?: int,
     *   unrestrict_boost_count?: int,
     *   message_auto_delete_time?: int,
     *   has_aggressive_anti_spam_enabled?: bool,
     *   has_hidden_members?: bool,
     *   has_protected_content?: bool,
     *   sticker_set_name?: string,
     *   can_set_sticker_set?: bool,
     *   linked_chat_id?: int,
     *   location?: array<string, mixed>
     * }>
     */
    public function mapResponse(array $result): array
    {
        // Wrap the chat object in an associative array to match the expected return type
        return ['chat' => $result['result']];
    }
}
