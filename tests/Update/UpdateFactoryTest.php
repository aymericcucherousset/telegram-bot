<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Tests\Update;

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Update\UpdateFactory;

final class UpdateFactoryTest extends TestCase
{
    public function testCreatesUpdateFromTextMessage(): void
    {
        $factory = new UpdateFactory();
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = $factory->fromJson((string) json_encode([
            'message' => [
                'message_id' => 190,
                'text' => 'hello',
                'chat' => ['id' => 123],
            ],
            'update_id' => 456,
        ]), $bot);

        self::assertSame('message', $update->type);
        self::assertSame('hello', $update->message?->text);
        self::assertSame(123, $update->message->chatId->value());
        self::assertFalse($update->isCommand());
    }

    public function testDetectsCommand(): void
    {
        $factory = new UpdateFactory();
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = $factory->fromJson((string) json_encode([
            'message' => [
                'message_id' => 190,
                'text' => '/ping',
                'chat' => ['id' => 123],
            ],
            'update_id' => 456,
        ]), $bot);

        self::assertTrue($update->isCommand());
        self::assertSame('ping', $update->commandName());
        self::assertSame([], $update->commandArguments());
    }

    public function testParsesCommandArguments(): void
    {
        $factory = new UpdateFactory();
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = $factory->fromJson((string) json_encode([
            'message' => [
                'message_id' => 190,
                'text' => '/ping foo bar',
                'chat' => ['id' => 123],
            ],
            'update_id' => 456,
        ]), $bot);

        self::assertSame('ping', $update->commandName());
        self::assertSame(['foo', 'bar'], $update->commandArguments());
    }

    public function testDoesNotAlterRawText(): void
    {
        $factory = new UpdateFactory();
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = $factory->fromJson((string) json_encode([
            'message' => [
                'message_id' => 190,
                'text' => '  hello  ',
                'chat' => ['id' => 123],
            ],
            'update_id' => 456,
        ]), $bot);

        self::assertSame('  hello  ', $update->message?->text);
    }

    public function testHandlesMissingTextGracefully(): void
    {
        $factory = new UpdateFactory();
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = $factory->fromJson((string) json_encode([
            'message' => [
                'message_id' => 190,
                'chat' => ['id' => 123],
            ],
            'update_id' => 456,
        ]), $bot);
        self::assertNull($update->message?->text);
        self::assertFalse($update->isCommand());
    }

    public function testHandlesMissingChatIdGracefully(): void
    {
        $factory = new UpdateFactory();
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        self::expectException(\InvalidArgumentException::class);
        $factory->fromJson((string) json_encode([
            'message' => [
                'message_id' => 190,
                'text' => 'hello',
            ],
            'update_id' => 456,
        ]), $bot);
    }

    public function testCreatesUpdateFromCallbackQuery(): void
    {
        $factory = new UpdateFactory();
        $bot = new \Aymericcucherousset\TelegramBot\Bot\Bot(new \Tests\Fake\FakeTelegramClient());
        $update = $factory->fromJson((string) json_encode([
            'callback_query' => [
                'id' => 'abc123',
                'data' => 'some_data',
                'message' => [
                    'message_id' => 190,
                    'chat' => ['id' => 123],
                ],
            ],
            'update_id' => 456,
        ]), $bot);

        self::assertSame('callback_query', $update->type);
        self::assertSame('some_data', $update->callbackQuery?->data);
        self::assertSame(123, $update->callbackQuery->chatId->value());
    }
}
