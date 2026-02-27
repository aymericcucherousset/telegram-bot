## Telegram Bot API Coverage


### Available Methods

| Category  | Method                                                                                  | Supported |
|-----------|-----------------------------------------------------------------------------------------|-----------|
| Messages  | [sendMessage](../src/Method/Message/TextMessage.php)                                    |     ✅    |
| Messages  | [editMessageText](../src/Method/Message/EditMessageText.php)                            |     ✅    |
| Messages  | [deleteMessage](../src/Method/Message/DeleteMessage.php)                                |     ✅    |
| Messages  | [deleteMessages](../src/Method/Message/DeleteMessages.php)                              |     ✅    |
| Messages  | [sendPhoto](../src/Method/Message/PhotoMessage.php)                                     |     ✅    |
| Callback  | [answerCallbackQuery](../src/Method/CallbackQuery/AnswerCallbackQuery.php)              |     ✅    |
| Bot       | [getMyName](../src/Method/Bot/GetMyName.php)                                            |     ✅    |
| Bot       | [setMyName](../src/Method/Bot/SetMyName.php)                                            |     ✅    |
| Bot       | [getMyDescription](../src/Method/Bot/GetMyDescription.php)                              |     ✅    |
| Bot       | [setMyDescription](../src/Method/Bot/SetMyDescription.php)                              |     ✅    |
| Bot       | [getMyShortDescription](../src/Method/Bot/GetMyShortDescription.php)                    |     ✅    |
| Bot       | [setMyShortDescription](../src/Method/Bot/SetMyShortDescription.php)                    |     ✅    |
| Webhook   | [setWebhook](../src/Method/Webhook/SetWebhook.php)                                      |     ✅    |
| Webhook   | [deleteWebhook](../src/Method/Webhook/DeleteWebhook.php)                                |     ✅    |
| Messages  | [sendAudio](../src/Method/Message/AudioMessage.php)                                     |     ✅    |
| Messages  | [sendDocument](../src/Method/Message/SendDocument.php)                                  |     ✅    |
| Messages  | [sendVideo](../src/Method/Message/VideoMessage.php)                                     |     ✅    |
| Messages  | sendAnimation                                                                           |     ❌    |
| Messages  | sendVoice                                                                               |     ❌    |
| Messages  | sendVideoNote                                                                           |     ❌    |
| Messages  | sendMediaGroup                                                                          |     ❌    |
| Messages  | sendLocation                                                                            |     ❌    |
| Messages  | sendVenue                                                                               |     ❌    |
| Messages  | sendContact                                                                             |     ❌    |
| Messages  | sendPoll                                                                                |     ❌    |
| Messages  | sendDice                                                                                |     ❌    |
| Messages  | sendChatAction                                                                          |     ❌    |
| Messages  | forwardMessage                                                                          |     ❌    |
| Messages  | forwardMessages                                                                         |     ❌    |
| Messages  | copyMessage                                                                             |     ❌    |
| Messages  | copyMessages                                                                            |     ❌    |
| Messages  | editMessageCaption                                                                      |     ❌    |
| Messages  | editMessageMedia                                                                        |     ❌    |
| Messages  | editMessageReplyMarkup                                                                  |     ❌    |
| Messages  | stopPoll                                                                                |     ❌    |
| Messages  | stopMessageLiveLocation                                                                 |     ❌    |
| Messages  | sendInvoice                                                                             |     ❌    |
| Messages  | createInvoiceLink                                                                       |     ❌    |
| Messages  | answerShippingQuery                                                                     |     ❌    |
| Messages  | answerPreCheckoutQuery                                                                  |     ❌    |
| Messages  | sendGame                                                                                |     ❌    |
| Messages  | setGameScore                                                                            |     ❌    |
| Messages  | getGameHighScores                                                                       |     ❌    |
| Callback  | answerInlineQuery                                                                       |     ❌    |
| Callback  | answerWebAppQuery                                                                       |     ❌    |
| Chat      | getChat                                                                                 |     ❌    |
| Chat      | getChatAdministrators                                                                   |     ❌    |
| Chat      | getChatMemberCount                                                                      |     ❌    |
| Chat      | getChatMember                                                                           |     ❌    |
| Chat      | setChatStickerSet                                                                       |     ❌    |
| Chat      | deleteChatStickerSet                                                                    |     ❌    |
| Chat      | setChatPhoto                                                                            |     ❌    |
| Chat      | deleteChatPhoto                                                                         |     ❌    |
| Chat      | setChatTitle                                                                            |     ❌    |
| Chat      | setChatDescription                                                                      |     ❌    |
| Chat      | pinChatMessage                                                                          |     ❌    |
| Chat      | unpinChatMessage                                                                        |     ❌    |
| Chat      | leaveChat                                                                               |     ❌    |
| Chat      | unbanChatMember                                                                         |     ❌    |
| Chat      | restrictChatMember                                                                      |     ❌    |
| Chat      | promoteChatMember                                                                       |     ❌    |
| Chat      | banChatMember                                                                           |     ❌    |
| Chat      | unbanChatSenderChat                                                                     |     ❌    |
| Chat      | setChatPermissions                                                                      |     ❌    |
| Chat      | exportChatInviteLink                                                                    |     ❌    |
| Chat      | createChatInviteLink                                                                    |     ❌    |
| Chat      | editChatInviteLink                                                                      |     ❌    |
| Chat      | revokeChatInviteLink                                                                    |     ❌    |
| Chat      | approveChatJoinRequest                                                                  |     ❌    |
| Chat      | declineChatJoinRequest                                                                  |     ❌    |
| Chat      | setChatMenuButton                                                                       |     ❌    |
| Chat      | getChatMenuButton                                                                       |     ❌    |
| Chat      | setMyCommands                                                                           |     ❌    |
| Chat      | getMyCommands                                                                           |     ❌    |
| Chat      | setMyDefaultAdministratorRights                                                         |     ❌    |
| Chat      | getMyDefaultAdministratorRights                                                         |     ❌    |
| User      | getUserProfilePhotos                                                                    |     ❌    |
| User      | getFile                                                                                 |     ❌    |
| User      | getMe                                                                                   |     ❌    |
| User      | logOut                                                                                  |     ❌    |
| User      | close                                                                                   |     ❌    |
| Other     | [setWebhook](../src/Method/Webhook/SetWebhook.php)                                      |     ✅    |
| Other     | [deleteWebhook](../src/Method/Webhook/DeleteWebhook.php)                                |     ✅    |
| Other     | [getWebhookInfo](../src/Method/Webhook/WebhookInfo.php)                                 |     ✅    |
| Other     | setPassportDataErrors                                                                   |     ❌    |
| Other     | sendSticker                                                                             |     ❌    |
| Other     | getStickerSet                                                                           |     ❌    |
| Other     | uploadStickerFile                                                                       |     ❌    |
| Other     | createNewStickerSet                                                                     |     ❌    |
| Other     | addStickerToSet                                                                         |     ❌    |
| Other     | setStickerPositionInSet                                                                 |     ❌    |
| Other     | deleteStickerFromSet                                                                    |     ❌    |
| Other     | setStickerSetThumb                                                                      |     ❌    |
| Payments  | sendInvoice                                                                             |     ❌    |
| Payments  | createInvoiceLink                                                                       |     ❌    |
| Payments  | answerShippingQuery                                                                     |     ❌    |
| Payments  | answerPreCheckoutQuery                                                                  |     ❌    |
| Games     | sendGame                                                                                |     ❌    |
| Games     | setGameScore                                                                            |     ❌    |
| Games     | getGameHighScores                                                                       |     ❌    |

## Unsupported Methods

The following Telegram API features are currently not implemented:

- Payments
- Games
- Inline Mode
