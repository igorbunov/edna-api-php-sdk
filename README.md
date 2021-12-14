# edna-php-sdk
### PHP SDK для работы с Мессенджером edna api

##### Примечание:

> В данном sdk реализованы только функции отправки сообщений

#### Официальная документация:

<https://edna.docs.apiary.io/#reference/api>

#### Установка:
```bash
composer require igorbunov/edna-api-php-sdk
```

#### Настройка:

```php
require_once 'vendor/autoload.php';
```

##### Начало работы:

```php
$api = new \igorbunov\Edna\EdnaJsonApi(
    new \igorbunov\Edna\Config\Config('апи ключ'), // берется из профиля edna
    new \igorbunov\Edna\Validator\ResponseValidator() // валидация ошибок, при желании можно заменить на свой класс
);
```

##### Отправка сообщения:

```php
$message = (new \igorbunov\Edna\Message\ImOutMessage())
    ->subject("ваш отправитель")
    ->address('телефон')
    ->text('текст сообщения');

$result = $api->imOutMessage($message): \igorbunov\Edna\MessageStatus\ImOutSuccess;
```

###### Список доступных методов ImOutMessage:

```php
// обязательно*
subject(string $subject) // обязательно*, отправитель сообщения (создается в профиле)
address(string $address) // обязательно*, телефон получателя (без плюсов и лишних знаков, просто цифры)
text(string $text) // обязательно*, текст сообщения

// не обязательно
contentType(string $type) // Тип содержимого сообщения. Возможные значения:
                          // text - текстовое сообщение
                          // image - изображение
                          // document - документ, вложенный в сообщение
                          // video - сообщение, содержащее видео
                          // audio - сообщение, содержащее звук
                          // location - сообщение с координатами, адресом и описанием места. Координаты преобразуются в снимок Google maps
messageId(string $messageId) // id сообщения, если не передать, то сгенерируется автоматически
priority(string $priority) // приоритет сообщения
                           // realtime - сообщение должно быть доставлено немедленно
                           // high - сообщение с высоким приоритетом
                           // normal - сообщение со стандартным приоритетом
                           // low - сообщение с низким приоритетом
validityPeriodSeconds(int $validityPerSeconds) // Время (в секундах), в течении которого должно быть доставлено сообщение.
startTime(string $dateTime) // Время, раньше которого сообщение не будет отправлено. Формат (2020-06-12T15:30:10.000Z)
attachmentName(string $attachmentName) // Название прикрепленного изображения\документа\видео (для аудио нельзя).
attachmentUrl(string $attachmentUrl) // URL прикрепленного изображения\документа\видео. Важно (URL должен начинаться с https)
latitude(string $latitude) // Долгота геолокации. Обязательно если contentType='location'
longitude(string $longitude) // Широта геолокации. Обязательно если contentType='location'
locationAddress(string $locationAddress) // Адрес геолокации. Используется только при contentType='location'
caption(string $caption) // Название геолокации. Используется только при contentType='location'
comment(string $comment) // Текстовый комментарий в сообщении. Значение параметра отображается в детальном отчете.
```

##### Отправка HSM сообщения:

```php
$message = (new \igorbunov\Edna\Message\ImOutHSM())
    ->subject("ваш отправитель")
    ->address('телефон')
    ->text('текст сообщения')
    ->headerText('заголовок')
    ->footer('подпись')
    ->addUrlButton('текст ссылки', 'https://ссылка');

$result = $api->imOutHSM($message): \igorbunov\Edna\MessageStatus\ImOutSuccess;
```

###### Список доступных методов ImOutHSM:

```php
// обязательно*
subject(string $subject) // обязательно*, отправитель сообщения (создается в профиле)
address(string $address) // обязательно*, телефон получателя (без плюсов и лишних знаков, просто цифры)
text(string $text) // обязательно*, текст сообщения

// не обязательно (отличные от ImOutMessage)
headerText(string $text) // Заголовок сообщения. текст.
headerImage(string $imageUrl) // Заголовок сообщения. изображение.
headerDocument(string $documentUrl, string $documentName) // Заголовок сообщения. документ.
headerVideo(string $videoUrl, string $videoName) // Заголовок сообщения. видео.
footer(string $text) // Подпись. Отображается под сообщением приглушенным цветом текста
addTextButton(string $buttonText) // Текстовая кнопка
addPhoneButton(string $buttonText, string $phone) // Телефонная кнопка
addUrlButton(string $buttonText, string $url) // Кнопка - ссылка
addQuickReplyButton(string $buttonText, string $payload) // Кнопка - ответ

// не обязательно (такие же как и для ImOutMessage)
contentType(string $type) // Тип содержимого сообщения. Возможные значения:
                          // text - текстовое сообщение
                          // image - изображение
                          // document - документ, вложенный в сообщение
                          // video - сообщение, содержащее видео
                          // audio - сообщение, содержащее звук
                          // location - сообщение с координатами, адресом и описанием места. Координаты преобразуются в снимок Google maps
messageId(string $messageId) // id сообщения, если не передать, то сгенерируется автоматически
priority(string $priority) // приоритет сообщения
                           // realtime - сообщение должно быть доставлено немедленно
                           // high - сообщение с высоким приоритетом
                           // normal - сообщение со стандартным приоритетом
                           // low - сообщение с низким приоритетом
validityPeriodSeconds(int $validityPerSeconds) // Время (в секундах), в течении которого должно быть доставлено сообщение.
startTime(string $dateTime) // Время, раньше которого сообщение не будет отправлено. Формат (2020-06-12T15:30:10.000Z)
attachmentName(string $attachmentName) // Название прикрепленного изображения\документа\видео (для аудио нельзя).
attachmentUrl(string $attachmentUrl) // URL прикрепленного изображения\документа\видео. Важно (URL должен начинаться с https)
latitude(string $latitude) // Долгота геолокации. Обязательно если contentType='location'
longitude(string $longitude) // Широта геолокации. Обязательно если contentType='location'
locationAddress(string $locationAddress) // Адрес геолокации. Используется только при contentType='location'
caption(string $caption) // Название геолокации. Используется только при contentType='location'
comment(string $comment) // Текстовый комментарий в сообщении. Значение параметра отображается в детальном отчете.
```

##### Получить статус сообщения:

```php
    $result = $api->imOutMessageId('id сообщения'): \igorbunov\Edna\MessageStatus\ImOutMessageStatus;
```

##### Ошибки (Exceptions):
```php
\igorbunov\Edna\Exceptions\ErrorSystemException - системная ошибка
\igorbunov\Edna\Exceptions\ErrorContentDoNotMatchHsmTemplateException - сообщение не соответствует зарегистрированному шаблону HSM.
\igorbunov\Edna\Exceptions\ErrorInsufficientBalanceException - недостаточно средств на балансе. Необходимо пополнить счет в личном кабинете либо обратиться к персональному менеджеру
\igorbunov\Edna\Exceptions\ErrorIdNotUniqueException - идентификатор сообщения не уникален в рамках всего взаимодействия
\igorbunov\Edna\Exceptions\ErrorSubjectFormatException - неправильный формат подписи
\igorbunov\Edna\Exceptions\ErrorSubjectUnknownException - указанная подпись не разрешена клиенту. Необходимо предварительно зарегистрировать все подписи.
\igorbunov\Edna\Exceptions\ErrorAddressFormatException - неправильный формат номера абонента
\igorbunov\Edna\Exceptions\ErrorAddressNotSpecifiedException - номер абонента не указан
\igorbunov\Edna\Exceptions\ErrorPriorityFormatException - неправильный формат значения приоритета
\igorbunov\Edna\Exceptions\ErrorStartTimeFormatException - неправильный формат отложенного времени отправки сообщения
\igorbunov\Edna\Exceptions\ErrorValidityPeriodSecondsFormatException - неправильный формат отложенного времени отправки.
\igorbunov\Edna\Exceptions\ErrorContentTypeFormatException - неправильный формат типа содержимого сообщения
\igorbunov\Edna\Exceptions\ErrorImTypeNotSpecifiedException - тип мессенджера не указан
\igorbunov\Edna\Exceptions\ErrorAttachmentUrlNotSpecifiedException - В параметре attachmentUrl передается пустое поле.
\igorbunov\Edna\Exceptions\ErrorLatitudeNotSpecifiedException - latitude (Широта) не указано.
\igorbunov\Edna\Exceptions\ErrorLongitudeNotSpecifiedException - longitude (Долгота) не указано.
\igorbunov\Edna\Exceptions\ErrorContentFormatException - неправильный формат содержимого сообщения
\igorbunov\Edna\Exceptions\ErrorContentTypeNotSpecifiedException - не указан тип вложения
\igorbunov\Edna\Exceptions\ErrorNotTemplateMatchException - неправильный формат шаблона
\igorbunov\Edna\Exceptions\ErrorSubjectIdFormatException - неправильный формат Id шаблона
\igorbunov\Edna\Exceptions\ErrorWhatsappUserException - адресат не является пользователем Whatsapp
\igorbunov\Edna\Exceptions\ErrorNotViberUserException - адресат не является пользователем Viber
\igorbunov\Edna\Exceptions\ErrorUserBlockedException - номер адресата заблокирован
\igorbunov\Edna\Exceptions\ErrorSystemBlockedException - система заблокирована
\igorbunov\Edna\Exceptions\ErrorSyntaxException - неправильный синтакс
\igorbunov\Edna\Exceptions\ErrorUnauthorizedException - ошибка авторизации
\igorbunov\Edna\Exceptions\ErrorNotFoundException - ошибка не определена
\igorbunov\Edna\Exceptions\UnknownCodeException - неизвестный код ошибки
\Exception  - стандартная ошибка
```
