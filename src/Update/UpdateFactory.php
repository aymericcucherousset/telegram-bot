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
        $payload = json_decode($json, true);

        if (!\is_array($payload) || !isset($payload['update_id'])) {
            throw new \InvalidArgumentException('Update ID missing from update data.');
        }

        // Support message update
        if (isset($payload['message']) && \is_array($payload['message'])) {
            // update_id, message_id, chat.id are always present and numeric (per Telegram API)
            if (!is_numeric($payload['message']['message_id'])) {
                throw new \InvalidArgumentException('Message ID must be numeric for message updates.');
            }
            if (!isset($payload['message']['chat']) || !\is_array($payload['message']['chat']) || !isset($payload['message']['chat']['id']) || !is_numeric($payload['message']['chat']['id'])) {
                throw new \InvalidArgumentException('Chat ID must be numeric for message updates.');
            }
            if (!is_numeric($payload['update_id'])) {
                throw new \InvalidArgumentException('Update ID must be numeric.');
            }
            $fromUserId = null;
            if (isset($payload['message']['from']) && \is_array($payload['message']['from']) && isset($payload['message']['from']['id'])) {
                if (!is_numeric($payload['message']['from']['id'])) {
                    throw new \InvalidArgumentException('From user ID must be numeric.');
                }
                $fromUserId = new UserId((int) $payload['message']['from']['id']);
            }
            $text = null;
            if (isset($payload['message']['text'])) {
                if (!\is_string($payload['message']['text'])) {
                    throw new \InvalidArgumentException('Text must be a string.');
                }
                $text = $payload['message']['text'];
            }
            $date = isset($payload['message']['date']) && is_numeric($payload['message']['date']) ? (int) $payload['message']['date'] : null;
            // ChatId accepts int|string, but Telegram always gives int for chat.id
            $chatIdValue = $payload['message']['chat']['id'];
            if (!\is_int($chatIdValue) && !\is_string($chatIdValue)) {
                throw new \InvalidArgumentException('Chat ID must be int or string.');
            }
            return new Update(
                id: (int) $payload['update_id'],
                message: new Message(
                    id: (int) $payload['message']['message_id'],
                    chatId: new ChatId($chatIdValue),
                    fromUserId: $fromUserId,
                    text: $text,
                    date: $date
                ),
                type: 'message'
            );
        }

        // Support callback_query update
        if (isset($payload['callback_query']) && \is_array($payload['callback_query'])) {
            $callback = $payload['callback_query'];
            if (!isset($callback['message']) || !\is_array($callback['message'])) {
                throw new \InvalidArgumentException('Callback query must contain a message.');
            }
            if (!is_numeric($callback['message']['message_id'])) {
                throw new \InvalidArgumentException('Message ID must be numeric for callback_query updates.');
            }
            if (!\is_array($callback['message']['chat']) || !is_numeric($callback['message']['chat']['id'])) {
                throw new \InvalidArgumentException('Chat ID must be numeric for callback_query updates.');
            }
            if (!is_numeric($payload['update_id'])) {
                throw new \InvalidArgumentException('Update ID must be numeric.');
            }
            if (!isset($callback['id']) || !\is_string($callback['id'])) {
                throw new \InvalidArgumentException('CallbackQuery id must be a string.');
            }
            if (!isset($callback['data']) || !\is_string($callback['data'])) {
                throw new \InvalidArgumentException('CallbackQuery data must be a string.');
            }
            $chatIdValue = $callback['message']['chat']['id'];
            if (!\is_int($chatIdValue) && !\is_string($chatIdValue)) {
                throw new \InvalidArgumentException('Chat ID must be int or string.');
            }
            return new Update(
                id: (int) $payload['update_id'],
                callbackQuery: new CallbackQuery(
                    id: $callback['id'],
                    data: $callback['data'],
                    chatId: new ChatId($chatIdValue),
                ),
                type: 'callback_query'
            );
        }
        throw new \InvalidArgumentException('Unsupported update type.');
    }
}
