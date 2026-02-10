<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Update;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\UserId;
use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Update\Message;

/**
 * @phpstan-type TelegramJsonMessage array{
 *   update_id: int,
 *   message: array{
 *     message_id: int,
 *     chat: array{
 *       id: int,
 *     },
 *     from?: array{
 *       id: int,
 *     },
 *     text?: string,
 *     date?: int
 *   }
 * }
 */
final class UpdateFactory
{
    public static function fromJson(string $json): Update
    {
        $data = json_decode($json, true);

        if (!\is_array($data) || !isset($data['message']) || !\is_array($data['message'])) {
            throw new \InvalidArgumentException('Only message updates are supported for now.');
        }

        if (!isset($data['message']['message_id'])) {
            throw new \InvalidArgumentException('Message ID is required for message updates.');
        }

        if (
            !isset($data['message']['chat'])
            || !\is_array($data['message']['chat'])
            || !isset($data['message']['chat']['id'])
        ) {
            throw new \InvalidArgumentException('Chat ID is required for message updates.');
        }

        if (!isset($data['update_id'])) {
            throw new \InvalidArgumentException('Update ID missing from update data.');
        }

        /** @var TelegramJsonMessage $data */
        return new Update(
            id: $data['update_id'],
            message: new Message(
                id: $data['message']['message_id'],
                chatId: new ChatId($data['message']['chat']['id']),
                fromUserId: isset($data['message']['from']['id']) ? new UserId($data['message']['from']['id']) : null,
                text: $data['message']['text'] ?? null,
                date: $data['message']['date'] ?? null
            ),
            type: 'message'
        );
    }
}
