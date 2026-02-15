<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Tests\Command;

use Aymericcucherousset\TelegramBot\Attribute\AsTelegramCommand;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Loader\AttributeHandlerLoader;
use Aymericcucherousset\TelegramBot\Registry\HandlerRegistryInterface;
use Aymericcucherousset\TelegramBot\Update\Update;
use PHPUnit\Framework\TestCase;

/**
 * Test registry for command registration tracking
 */
class TestRegistry implements HandlerRegistryInterface
{
    /**
     * @var array<int, array{string, HandlerInterface}>
     */
    public array $calls = [];
    public function register(string $name, HandlerInterface $handler): void
    {
        $this->calls[] = [$name, $handler];
    }

    public function dispatch(Update $update): void {}
}

class PingCommand implements HandlerInterface
{
    public function handle(Update $update): void {}
}

#[AsTelegramCommand('ping')]
class PingCommandWithAttribute extends PingCommand {}

class StartCommand implements HandlerInterface
{
    public function handle(Update $update): void {}
}

#[AsTelegramCommand('start')]
class StartCommandWithAttribute extends StartCommand {}

final class AttributeHandlerLoaderTest extends TestCase
{
    public function testRegistersCommandWithAttribute(): void
    {
        $command = new PingCommandWithAttribute();
        $registry = new TestRegistry();
        $loader = new AttributeHandlerLoader();
        $loader->load([$command], $registry);
        /** @var TestRegistry $registry */
        self::assertCount(1, $registry->calls);
        self::assertSame('ping', $registry->calls[0][0]);
        self::assertSame($command, $registry->calls[0][1]);
    }

    public function testIgnoresCommandWithoutAttribute(): void
    {
        $command = new PingCommand();
        $registry = new TestRegistry();
        $loader = new AttributeHandlerLoader();
        $loader->load([$command], $registry);
        /** @var TestRegistry $registry */
        self::assertCount(0, $registry->calls);
    }

    public function testRegistersMultipleCommands(): void
    {
        $ping = new PingCommandWithAttribute();
        $start = new StartCommandWithAttribute();
        $registry = new TestRegistry();
        $loader = new AttributeHandlerLoader();
        $loader->load([$ping, $start], $registry);
        /** @var TestRegistry $registry */
        self::assertCount(2, $registry->calls);
        self::assertSame(['ping', $ping], $registry->calls[0]);
        self::assertSame(['start', $start], $registry->calls[1]);
    }
}
