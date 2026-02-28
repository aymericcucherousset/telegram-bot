<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getChatAdministrators method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getchatadministrators
 *
 * @implements TelegramMethod<array<string, array<int, array{
 *   status: "administrator",
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
 *   can_be_edited: bool,
 *   is_anonymous: bool,
 *   can_manage_chat: bool,
 *   can_delete_messages: bool,
 *   can_manage_video_chats: bool,
 *   can_restrict_members: bool,
 *   can_promote_members: bool,
 *   can_change_info: bool,
 *   can_invite_users: bool,
 *   can_post_messages?: bool,
 *   can_edit_messages?: bool,
 *   can_pin_messages?: bool,
 *   custom_title?: string
 * }>>>
 */
final class GetChatAdministrators implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target supergroup or channel
     */
    public function __construct(
        private readonly ChatId $chatId,
    ) {}

    public function getMethod(): string
    {
        return 'getChatAdministrators';
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
     * @param array{ok: bool, result: array<int, array{
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
     *   is_anonymous?: bool,
     *   custom_title?: string
     * }> } $result
     *
     * @return array<string, array<int, array{
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
     *   is_anonymous?: bool,
     *   custom_title?: string
     * }>>
     */
    public function mapResponse(array $result): array
    {
        // Wrap the administrators array in an associative array to match the expected return type
        return ['administrators' => $result['result']];
    }
}
