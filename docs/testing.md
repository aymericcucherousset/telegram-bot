# Testing

Testing is a first-class concern in the telegram-bot-sdk. The package is designed for high testability, leveraging strict typing, value objects, and clear boundaries between domain and infrastructure.

## Unit Testing

Write fast, isolated tests for your domain logic, handlers, and value objects. Use PHPUnit as the test runner. Example:

```php
use Aymericcucherousset\TelegramBot\Value\ChatId;
use PHPUnit\Framework\TestCase;

class ChatIdTest extends TestCase
{
	public function testValueObject(): void
	{
		$chatId = new ChatId(123456);
		$this->assertSame(123456, $chatId->toInt());
	}
}
```

## Mocking HTTP Clients

The SDK relies on PSR-18 HTTP clients. For unit tests, mock the HTTP client to avoid real API calls. Use libraries like `php-http/mock-client` or PHPUnit's built-in mocking:

```php
use Aymericcucherousset\TelegramBot\Api\HttpTelegramClient;
use Psr\Http\Client\ClientInterface;
use PHPUnit\Framework\TestCase;

class HttpTelegramClientTest extends TestCase
{
	public function testSendRequest(): void
	{
		$mock = $this->createMock(ClientInterface::class);
		// Configure $mock to expect/send requests
		$client = new HttpTelegramClient('TOKEN', $mock);
		// ...assertions...
	}
}
```
## Test Utilities

- FakeTelegramClient: Simulate Telegram API responses for deterministic tests.
- SpyCommand: Assert command invocations and side effects.
- Test factories: Quickly create Update, Message, and CallbackQuery objects.

See the `tests/` directory for real-world examples and patterns.

## Note on Bot and UpdateFactory

When testing code that uses `UpdateFactory`, remember that it now requires a `Bot` instance as the second argument:

```php
use Aymericcucherousset\TelegramBot\Update\UpdateFactory;
use Aymericcucherousset\TelegramBot\Bot\Bot;

$bot = new Bot($client); // $client is your TelegramClientInterface implementation (can be a fake/mock)
$update = UpdateFactory::fromJson($json, $bot);
```
