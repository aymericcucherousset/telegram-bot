<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Update\Message;
use Aymericcucherousset\TelegramBot\Value\ChatId;

final class MessageTest extends TestCase
{
    public function testIsCommandWithNoText(): void
    {
        $msg = new Message(1, new ChatId(123), null, null);
        self::assertFalse($msg->isCommand());
    }

    public function testIsCommandWithSlash(): void
    {
        $msg = new Message(2, new ChatId(123), null, '/start');
        self::assertTrue($msg->isCommand());
    }

    public function testCommandNameSimple(): void
    {
        $msg = new Message(3, new ChatId(123), null, '/start test');
        self::assertSame('start', $msg->commandName());
    }

    public function testCommandNameWithBot(): void
    {
        $msg = new Message(4, new ChatId(123), null, '/ping@my_bot');
        self::assertSame('ping', $msg->commandName());
    }

    public function testCommandArguments(): void
    {
        $msg = new Message(5, new ChatId(123), null, '/ban user1 now');
        self::assertSame(['user1', 'now'], $msg->commandArguments());
    }

    public function testCommandNameThrowsOnNonCommand(): void
    {
        $msg = new Message(6, new ChatId(123), null, 'hello world');
        $this->expectException(\LogicException::class);
        $msg->commandName();
    }
}
