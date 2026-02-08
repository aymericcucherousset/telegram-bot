# Telegram Bot

## Installation

```bash
composer require aymericccuherousset/telegram-bot
```

## Usage

```php
$bot = new Bot($client);
$bot->onCommand('/ping', new PingCommand());
$bot->handle($update);
```

## Structure

```
telegram-bot/
├── composer.json
├── README.md
├── phpunit.xml
├── src/
│   ├── Bot/
│   │   └── Bot.php
│   ├── Api/
│   │   ├── TelegramClientInterface.php
│   │   └── HttpTelegramClient.php
│   ├── Update/
│   │   ├── Update.php
│   │   ├── Message.php
│   │   └── UpdateFactory.php
│   ├── Command/
│   │   ├── CommandInterface.php
│   │   ├── CommandRegistry.php
│   │   └── CommandContext.php
│   ├── Handler/
│   │   ├── UpdateHandlerInterface.php
│   │   └── MessageHandler.php
│   ├── Value/
│   │   ├── ChatId.php
│   │   ├── UserId.php
│   │   └── ParseMode.php
│   ├── Exception/
│   │   ├── TelegramException.php
│   │   └── ApiException.php
│   └── Support/
│       └── Arr.php
├── tests/
│   ├── Fake/
│   │   └── FakeTelegramClient.php
│   └── BotTest.php
└── .github/
    └── workflows/ci.yml
```
