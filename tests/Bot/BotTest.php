<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Bot\Bot;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Update\Message;
use Tests\Fake\SpyCommand;

final class BotTest extends TestCase
{
    public function testPingCommandIsCalled(): void
    {
        $bot = new Bot();
        $spy = new SpyCommand();
        $bot->onCommand('ping', $spy);
        $update = new Update(1, new Message(1, new ChatId(123), null, '/ping'), type: 'message');
        $bot->handle($update);
        self::assertTrue($spy->called);
    }

    public function testNormalMessageDoesNothing(): void
    {
        $bot = new Bot();
        $spy = new SpyCommand();
        $bot->onCommand('ping', $spy);
        $update = new Update(2, new Message(2, new ChatId(123), null, 'hello world'), type: 'message');
        $bot->handle($update);
        self::assertFalse($spy->called);
    }

    public function testUnknownCommandDoesNothing(): void
    {
        $bot = new Bot();
        $spy = new SpyCommand();
        $bot->onCommand('ping', $spy);
        $update = new Update(3, new Message(3, new ChatId(123), null, '/unknown'), type: 'message');
        $bot->handle($update);
        self::assertFalse($spy->called);
    }
}
