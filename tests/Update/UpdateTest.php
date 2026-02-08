<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Update\Message;
use Aymericcucherousset\TelegramBot\Value\ChatId;

final class UpdateTest extends TestCase
{
    public function testIsCommandWithoutMessage(): void
    {
        $update = new Update(1, null);
        self::assertFalse($update->isCommand());
    }

    public function testIsCommandWithCommandMessage(): void
    {
        $msg = new Message(2, new ChatId(123), null, '/start');
        $update = new Update(2, $msg);
        self::assertTrue($update->isCommand());
    }

    public function testCommandNameRelayed(): void
    {
        $msg = new Message(3, new ChatId(123), null, '/ping@my_bot');
        $update = new Update(3, $msg);
        self::assertSame('ping', $update->commandName());
    }
}
