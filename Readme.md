
# aymericcucherousset/telegram-bot

![PHP Version](https://img.shields.io/badge/php-%3E%3D8.4-8892BF.svg)
![License](https://img.shields.io/github/license/aymericcucherousset/telegram-bot)
![CI](https://github.com/aymericcucherousset/telegram-bot/actions/workflows/ci.yml/badge.svg)

---

## Description

**Telegram Bot** is a modern, Clean Architecture-oriented PHP package for building robust Telegram bots. Designed for PHP 8.4+, it leverages DDD principles, strict typing, and PSR-18 HTTP clients. The package provides a clear Domain/Infrastructure separation, value objects, and extensible message patterns for maintainable, testable, and scalable bot development.

## Goals

- Promote Clean Architecture and DDD for Telegram bots
- Provide a strict, type-safe, and extensible API
- Encapsulate Telegram API calls via OutboundMessageInterface
- Support for value objects and inline keyboards
- Easy integration with any PSR-18 HTTP client

## Installation

```bash
composer require aymericcucherousset/telegram-bot
```

## Basic Usage

```php
use Aymericcucherousset\TelegramBot\Api\HttpTelegramClient;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Attribute\AsTelegramCommand;
use Aymericcucherousset\TelegramBot\Method\Message\TextMessage;
use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardButton;
use Aymericcucherousset\TelegramBot\Update\Update;

#[AsTelegramCommand(name: 'ping', description: 'Replies with pong')]
final class PingCommand implements HandlerInterface
{
    public function __construct(
        private readonly HttpTelegramClient $client,
    ) {}

    public function handle(Update $update): void
    {
        $message = $update->message;

        if ($message === null) {
            return;
        }

        $textMessage = new TextMessage(
            chatId: $message->chatId,
            text: 'pong 🏓',
        );
        $this->client->send($textMessage);
    }
}
```

## Example: Inline Keyboard

```php
use Aymericcucherousset\TelegramBot\Method\Message\TextMessage;
use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardButton;
use Aymericcucherousset\TelegramBot\Value\ChatId;

$keyboard = new InlineKeyboardMarkup([
    [new InlineKeyboardButton('Button 1', callbackData: 'action_1')],
    [new InlineKeyboardButton('Button 2', callbackData: 'action_2')],
]);

$message = new TextMessage(
    new ChatId(123456789),
    'Choose an option:',
    replyMarkup: $keyboard
);
```

## Example: CallbackQuery Handling

```php
use Aymericcucherousset\TelegramBot\Api\HttpTelegramClient;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Attribute\AsTelegramCallbackQuery;
use Aymericcucherousset\TelegramBot\Message\EditMessageText;
use Aymericcucherousset\TelegramBot\Update\Update;
use Aymericcucherousset\TelegramBot\Value\ParseMode;

#[AsTelegramCallbackQuery(name: 'products', description: 'Replies with the list of products')]
final class ProductsCallbackQuery implements HandlerInterface
{
    public function __construct(
        private readonly HttpTelegramClient $client,
    ) {}

    public function handle(Update $update): void
    {
        $callbackQuery = $update->callbackQuery;

        if ($callbackQuery === null) {
            return;
        }

        $editMessage = new EditMessageText(
            chatId: $callbackQuery->chatId,
            messageId: $update->message->id,
            text: 'List of products : ...',
            mode: ParseMode::Markdown,
        );
        $this->client->send($editMessage);
    }
}
```

## Architecture

```
src/
├── Api/         # PSR-18 HTTP client, API interfaces
├── Attribute/   # Command/callback attributes
├── Method/     # TelegramMethod interface
│   ├── TelegramMethod.php   # TelegramMethod interface
│   └── Message/             # Message-related methods (SendMessage, EditMessageText, etc.)
├── Bot/         # Bot orchestration
├── Exception/   # Domain & API exceptions
├── Handler/     # Handler interfaces/loaders
├── Keyboard/    # Inline keyboard markup/buttons
├── Loader/      # Attribute handler loader
├── Message/     # OutboundMessageInterface & implementations
├── Registry/    # Handler registries
├── Update/      # Update, Message, CallbackQuery, factories
├── Value/       # Value Objects (ChatId, ParseMode, UserId)
```

```
ASCII Architecture:

   +-------------------+
   |   Domain Layer    |
   |-------------------|
   |  Value Objects    |
   |  OutboundMessage  |
   |  Handlers         |
   +-------------------+
            |
            v
   +------------------------+
   |  Infrastructure Layer  |
   |------------------------|
   |  PSR-18 HTTP Client    |
   |  API Integration       |
   +------------------------+
```

## Philosophy

- **Domain-Driven Design**: Core logic and value objects are decoupled from infrastructure.
- **Value Objects**: (ChatId, ParseMode, UserId) ensure type safety and immutability.
- **OutboundMessageInterface**: Encapsulates all outbound API calls for extensibility.
- **Extensible**: Add new message types or handlers without modifying core logic.
- **Strict Types**: All code uses `declare(strict_types=1)`.

## Roadmap

- [x] Core message types (SendMessage, EditMessageText, AnswerCallbackQuery, DeleteMessage)
- [x] Inline keyboard support
- [x] Exception handling (ApiException)
- [ ] File upload (photo, document, etc.)
- [ ] Symfony Bundle
- [ ] More update types and handlers

## Contributing

Contributions are welcome! Please submit pull requests with clear descriptions and tests. Follow PSR-12 and Clean Architecture principles.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
