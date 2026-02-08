<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Update\Message;
use Aymericcucherousset\TelegramBot\Command\CommandContext;
use Aymericcucherousset\TelegramBot\Command\CommandRegistry;
use Aymericcucherousset\TelegramBot\Command\CommandInterface;
use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;

#[AllowMockObjectsWithoutExpectations]
final class CommandRegistryTest extends TestCase
{
    public function testRegisteredCommandIsCalled(): void
    {
        $registry = new CommandRegistry();
        $called = false;
        $mockCommand = new class implements CommandInterface {
            public bool $called = false;
            public function handle(CommandContext $context): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mockCommand);
        $update = new Update(1, new Message(1, new ChatId(123), null, '/start'));
        $registry->dispatch($update, $this->createMock(TelegramClientInterface::class));
        self::assertTrue($mockCommand->called);
    }

    public function testCorrectCommandIsCalled(): void
    {
        $registry = new CommandRegistry();
        $mockA = new class implements CommandInterface {
            public bool $called = false;
            public function handle(CommandContext $context): void
            {
                $this->called = true;
            }
        };
        $mockB = new class implements CommandInterface {
            public bool $called = false;
            public function handle(CommandContext $context): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mockA);
        $registry->register('ping', $mockB);
        $update = new Update(2, new Message(2, new ChatId(123), null, '/ping'));
        $registry->dispatch($update, $this->createMock(TelegramClientInterface::class));
        self::assertFalse($mockA->called);
        self::assertTrue($mockB->called);
    }

    public function testUnknownCommandDoesNothing(): void
    {
        $registry = new CommandRegistry();
        $mock = new class implements CommandInterface {
            public bool $called = false;
            public function handle(CommandContext $context): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mock);
        $update = new Update(3, new Message(3, new ChatId(123), null, '/unknown'));
        // Should not throw, should not call
        $registry->dispatch($update, $this->createMock(TelegramClientInterface::class));
        self::assertFalse($mock->called);
    }

    public function testNonCommandMessageDoesNothing(): void
    {
        $registry = new CommandRegistry();
        $mock = new class implements CommandInterface {
            public bool $called = false;
            public function handle(CommandContext $context): void
            {
                $this->called = true;
            }
        };
        $registry->register('start', $mock);
        $update = new Update(4, new Message(4, new ChatId(123), null, 'hello world'));
        // Should not throw, should not call
        $registry->dispatch($update, $this->createMock(TelegramClientInterface::class));
        self::assertFalse($mock->called);
    }
}
