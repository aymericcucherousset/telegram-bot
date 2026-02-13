# Callback Queries

Callback queries are triggered when a user interacts with an inline keyboard button. The SDK uses attribute-based handler classes for clean, extensible callback query processing.

## Defining a CallbackQuery Handler

Implement a handler class with the `AsTelegramCallbackQuery` attribute:

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

## InlineKeyboardButton Callback Data

- Each `InlineKeyboardButton::callback()` defines a `callback_data` payload.
- The SDK automatically routes incoming callback queries to the correct handler based on this data.

## Best Practices

- Keep callback data short and meaningful.
- Use value objects for IDs and payloads.
- Avoid side effects in handlers; delegate to services.
- Test callback handling with fake updates and clients.

See also: [API Reference](api-reference.md), [Testing](testing.md)
