<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getChatMember method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getchatmember
 *
 * @implements TelegramMethod<array<string, array{
 *   status: string,
 *   user: array{
 *     id: int,
 *     is_bot: bool,
 *     first_name: string,
 *     last_name?: string,
 *     username?: string,
 *     language_code?: string,
 *     can_join_groups?: bool,
 *     can_read_all_group_messages?: bool,
 *     supports_inline_queries?: bool
 *   },
 *   until_date?: int,
 *   can_be_edited?: bool,
 *   can_manage_chat?: bool,
 *   can_post_messages?: bool,
 *   can_edit_messages?: bool,
 *   can_delete_messages?: bool,
 *   can_manage_video_chats?: bool,
 *   can_restrict_members?: bool,
 *   can_promote_members?: bool,
 *   can_change_info?: bool,
 *   can_invite_users?: bool,
 *   can_pin_messages?: bool,
 *   is_member?: bool,
 *   can_send_messages?: bool,
 *   can_send_media_messages?: bool,
 *   can_send_polls?: bool,
 *   can_send_other_messages?: bool,
 *   can_add_web_page_previews?: bool,
 *   custom_title?: string,
 *   is_anonymous?: bool
 * }>>
 */
final class GetChatMember implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target supergroup or channel
     * @param int $userId Unique identifier of the target user
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly int $userId,
    ) {}

    public function getMethod(): string
    {
        return 'getChatMember';
    }

    /**
     * @return array{chat_id: int|string, user_id: int}
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId->value(),
            'user_id' => $this->userId,
        ];
    }

    /**
     * @param array{ok: bool, result: array{
     *   status: string,
     *   user: array{
     *     id: int,
     *     is_bot: bool,
     *     first_name: string,
     *     last_name?: string,
     *     username?: string,
     *     language_code?: string,
     *     can_join_groups?: bool,
     *     can_read_all_group_messages?: bool,
     *     supports_inline_queries?: bool
     *   },
     *   until_date?: int,
     *   can_be_edited?: bool,
     *   can_manage_chat?: bool,
     *   can_post_messages?: bool,
     *   can_edit_messages?: bool,
     *   can_delete_messages?: bool,
     *   can_manage_video_chats?: bool,
     *   can_restrict_members?: bool,
     *   can_promote_members?: bool,
     *   can_change_info?: bool,
     *   can_invite_users?: bool,
     *   can_pin_messages?: bool,
     *   is_member?: bool,
     *   can_send_messages?: bool,
     *   can_send_media_messages?: bool,
     *   can_send_polls?: bool,
     *   can_send_other_messages?: bool,
     *   can_add_web_page_previews?: bool,
     *   custom_title?: string,
     *   is_anonymous?: bool
     * }} $result
     *
     * @return array<string, array{
     *   status: string,
     *   user: array{
     *     id: int,
     *     is_bot: bool,
     *     first_name: string,
     *     last_name?: string,
     *     username?: string,
     *     language_code?: string,
     *     can_join_groups?: bool,
     *     can_read_all_group_messages?: bool,
     *     supports_inline_queries?: bool
     *   },
     *   until_date?: int,
     *   can_be_edited?: bool,
     *   can_manage_chat?: bool,
     *   can_post_messages?: bool,
     *   can_edit_messages?: bool,
     *   can_delete_messages?: bool,
     *   can_manage_video_chats?: bool,
     *   can_restrict_members?: bool,
     *   can_promote_members?: bool,
     *   can_change_info?: bool,
     *   can_invite_users?: bool,
     *   can_pin_messages?: bool,
     *   is_member?: bool,
     *   can_send_messages?: bool,
     *   can_send_media_messages?: bool,
     *   can_send_polls?: bool,
     *   can_send_other_messages?: bool,
     *   can_add_web_page_previews?: bool,
     *   custom_title?: string,
     *   is_anonymous?: bool
     * }>
     */
    public function mapResponse(array $result): array
    {
        // Wrap the chat member object in an associative array to match the expected return type
        return ['chat_member' => $result['result']];
    }
}
