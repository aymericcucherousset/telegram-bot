<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Value\ParseMode;

final class ParseModeTest extends TestCase
{
    public function testPlainReturnsNull(): void
    {
        self::assertNull(ParseMode::Plain->telegramValue());
    }

    public function testOthersReturnCorrectValue(): void
    {
        self::assertSame('Markdown', ParseMode::Markdown->telegramValue());
        self::assertSame('MarkdownV2', ParseMode::MarkdownV2->telegramValue());
        self::assertSame('HTML', ParseMode::HTML->telegramValue());
    }
}
