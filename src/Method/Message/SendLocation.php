<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the sendLocation method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#sendlocation
 *
 * @implements TelegramMethod<bool>
 */
final class SendLocation implements TelegramMethod
{
    /**
     * @param ChatId $chatId Unique identifier for the target chat or username of the target channel
     * @param float $latitude Latitude of the location
     * @param float $longitude Longitude of the location
     * @param int|null $messageThreadId Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param float|null $horizontalAccuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $livePeriod Period in seconds for which the location will be updated (see Live Locations, should be between 60 and 86400)
     * @param int|null $heading Direction in which the user is moving, in degrees; 1-360
     * @param int|null $proximityAlertRadius Maximum distance for proximity alerts about approaching another chat member, in meters; 0-100000
     * @param bool|null $disableNotification Sends the message silently. Users will receive a notification with no sound.
     * @param int|null $replyToMessageId If the message is a reply, ID of the original message
     * @param bool|null $allowSendingWithoutReply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param array<int, array<string, mixed>>|null $replyMarkup Additional interface options (inline keyboard, etc.)
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly float $latitude,
        private readonly float $longitude,
        private readonly ?int $messageThreadId = null,
        private readonly ?float $horizontalAccuracy = null,
        private readonly ?int $livePeriod = null,
        private readonly ?int $heading = null,
        private readonly ?int $proximityAlertRadius = null,
        private readonly ?bool $disableNotification = null,
        private readonly ?int $replyToMessageId = null,
        private readonly ?bool $allowSendingWithoutReply = null,
        private readonly ?array $replyMarkup = null,
    ) {}

    public function getMethod(): string
    {
        return 'sendLocation';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'chat_id' => $this->chatId->value(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'message_thread_id' => $this->messageThreadId,
            'horizontal_accuracy' => $this->horizontalAccuracy,
            'live_period' => $this->livePeriod,
            'heading' => $this->heading,
            'proximity_alert_radius' => $this->proximityAlertRadius,
            'disable_notification' => $this->disableNotification,
            'reply_to_message_id' => $this->replyToMessageId,
            'allow_sending_without_reply' => $this->allowSendingWithoutReply,
            'reply_markup' => $this->replyMarkup,
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
