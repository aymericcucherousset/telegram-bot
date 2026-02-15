<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Update\Message;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Registry\HandlerRegistry;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;

#[AllowMockObjectsWithoutExpectations]
final class HandlerRegistryTest extends TestCase
{
    public function testRegisteredCommandIsCalled(): void
    {
        $registry = new HandlerRegistry();
        $called = false;
        $mockCommand = new class implements HandlerInterface {
            public bool $called = false;
            public function handle(Update $update): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mockCommand);
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = new Update(1, $bot, new Message(1, new ChatId(123), null, '/start'), null, 'message');
        $registry->dispatch($update);
        self::assertTrue($mockCommand->called);
    }

    public function testCorrectCommandIsCalled(): void
    {
        $registry = new HandlerRegistry();
        $mockA = new class implements HandlerInterface {
            public bool $called = false;
            public function handle(Update $update): void
            {
                $this->called = true;
            }
        };
        $mockB = new class implements HandlerInterface {
            public bool $called = false;
            public function handle(Update $update): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mockA);
        $registry->register('ping', $mockB);
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = new Update(2, $bot, new Message(2, new ChatId(123), null, '/ping'), null, 'message');
        $registry->dispatch($update);
        self::assertFalse($mockA->called);
        self::assertTrue($mockB->called);
    }

    public function testUnknownCommandDoesNothing(): void
    {
        $registry = new HandlerRegistry();
        $mock = new class implements HandlerInterface {
            public bool $called = false;
            public function handle(Update $update): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mock);
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = new Update(3, $bot, new Message(3, new ChatId(123), null, '/unknown'), null, 'message');
        // Should not throw, should not call
        $registry->dispatch($update);
        self::assertFalse($mock->called);
    }

    public function testNonCommandMessageDoesNothing(): void
    {
        $registry = new HandlerRegistry();
        $mock = new class implements HandlerInterface {
            public bool $called = false;
            public function handle(Update $update): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mock);
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = new Update(4, $bot, new Message(4, new ChatId(123), null, 'hello world'), null, 'message');
        // Should not throw, should not call
        $registry->dispatch($update);
        self::assertFalse($mock->called);
    }
}
