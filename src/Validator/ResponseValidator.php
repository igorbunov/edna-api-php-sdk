<?php

namespace igorbunov\Edna\Validator;

use igorbunov\Edna\Validator\ValicatorContract;
use igorbunov\Edna\Exceptions\UnknownCodeException;
use igorbunov\Edna\Exceptions\EmptyResponseException;

class ResponseValidator implements ValicatorContract
{
    private $statuses = [
        // Статусы обработки сообщения
        'error-system' => [
            'message' => 'системная ошибка',
            'class' => '\igorbunov\Edna\Exceptions\ErrorSystemException'
        ],
        'error-content-do-not-match-hsm-template' => [
            'message' => 'сообщение не соответствует зарегистрированному шаблону HSM.',
            'class' => '\igorbunov\Edna\Exceptions\ErrorContentDoNotMatchHsmTemplateException'
        ],
        'error-insufficient-balance' => [
            'message' => 'недостаточно средств на балансе. Необходимо пополнить счет в личном кабинете либо обратиться к персональному менеджеру',
            'class' => '\igorbunov\Edna\Exceptions\ErrorInsufficientBalanceException'
        ],
        'error-id-not-unique' => [
            'message' => 'идентификатор сообщения не уникален в рамках всего взаимодействия',
            'class' => '\igorbunov\Edna\Exceptions\ErrorIdNotUniqueException'
        ],
        'error-subject-format' => [
            'message' => 'неправильный формат подписи',
            'class' => '\igorbunov\Edna\Exceptions\ErrorSubjectFormatException'
        ],
        'error-subject-unknown' => [
            'message' => 'указанная подпись не разрешена клиенту. Необходимо предварительно зарегистрировать все подписи.',
            'class' => '\igorbunov\Edna\Exceptions\ErrorSubjectUnknownException'
        ],
        'error-address-format' => [
            'message' => 'неправильный формат номера абонента',
            'class' => '\igorbunov\Edna\Exceptions\ErrorAddressFormatException'
        ],
        'error-address-not-specified' => [
            'message' => 'номер абонента не указан',
            'class' => '\igorbunov\Edna\Exceptions\ErrorAddressNotSpecifiedException'
        ],
        'error-priority-format' => [
            'message' => 'неправильный формат значения приоритета',
            'class' => '\igorbunov\Edna\Exceptions\ErrorPriorityFormatException'
        ],
        'error-start-time-format' => [
            'message' => 'неправильный формат отложенного времени отправки сообщения',
            'class' => '\igorbunov\Edna\Exceptions\ErrorStartTimeFormatException'
        ],
        'error-validity-period-seconds-format' => [
            'message' => 'неправильный формат отложенного времени отправки.',
            'class' => '\igorbunov\Edna\Exceptions\ErrorValidityPeriodSecondsFormatException'
        ],
        'error-content-type-format' => [
            'message' => 'неправильный формат типа содержимого сообщения',
            'class' => '\igorbunov\Edna\Exceptions\ErrorContentTypeFormatException'
        ],
        'error-im-type-not-specified' => [
            'message' => 'тип мессенджера не указан',
            'class' => '\igorbunov\Edna\Exceptions\ErrorImTypeNotSpecifiedException'
        ],
        'error-attachment-url-not-specified' => [
            'message' => 'В параметре attachmentUrl передается пустое поле.',
            'class' => '\igorbunov\Edna\Exceptions\ErrorAttachmentUrlNotSpecifiedException'
        ],
        'error-latitude-not-specified' => [
            'message' => 'latitude (Широта) не указано.',
            'class' => '\igorbunov\Edna\Exceptions\ErrorLatitudeNotSpecifiedException'
        ],
        'error-longtitude-not-specified' => [
            'message' => 'longitude (Долгота) не указано.',
            'class' => '\igorbunov\Edna\Exceptions\ErrorLongitudeNotSpecifiedException'
        ],
        'error-content-format' => [
            'message' => 'неправильный формат содержимого сообщения',
            'class' => '\igorbunov\Edna\Exceptions\ErrorContentFormatException'
        ],
        'error-content-type-not-specified' => [
            'message' => 'не указан тип вложения',
            'class' => '\igorbunov\Edna\Exceptions\ErrorContentTypeNotSpecifiedException'
        ],
        'error-not-template-match' => [
            'message' => 'неправильный формат шаблона',
            'class' => '\igorbunov\Edna\Exceptions\ErrorNotTemplateMatchException'
        ],
        'error-subject-id-format' => [
            'message' => 'неправильный формат Id шаблона',
            'class' => '\igorbunov\Edna\Exceptions\ErrorSubjectIdFormatException'
        ],
        'not-whatsapp-user' => [
            'message' => 'адресат не является пользователем Whatsapp',
            'class' => '\igorbunov\Edna\Exceptions\ErrorWhatsappUserException'
        ],
        'not-viber-user' => [
            'message' => 'адресат не является пользователем Viber',
            'class' => '\igorbunov\Edna\Exceptions\ErrorNotViberUserException'
        ],
        'user-blocked' => [
            'message' => 'номер адресата заблокирован',
            'class' => '\igorbunov\Edna\Exceptions\ErrorUserBlockedException'
        ],

        // Ошибки возникающие в коннекторе
        'error-system-blocked' => [
            'message' => 'система заблокирована',
            'class' => '\igorbunov\Edna\Exceptions\ErrorSystemBlockedException'
        ],
        'error-syntax' => [
            'message' => 'неправильный синтакс',
            'class' => '\igorbunov\Edna\Exceptions\ErrorSyntaxException'
        ],
        'error-unauthorized' => [
            'message' => 'ошибка авторизации',
            'class' => '\igorbunov\Edna\Exceptions\ErrorUnauthorizedException'
        ],
        'error-not-found' => [
            'message' => 'ошибка не определена',
            'class' => '\igorbunov\Edna\Exceptions\ErrorNotFoundException'
        ]
    ];

    public function validate(?array $response = []): void
    {
        if (empty($response)) {
            throw new EmptyResponseException('Пустой ответ от edna api');
        }

        if (!array_key_exists('code', $response)) {
            throw new \Exception('No code key in response: ' . \json_encode($response));
        }

        if ($response['code'] == 'ok') {
            return;
        }

        if (!array_key_exists($response['code'], $this->statuses)) {
            throw new UnknownCodeException('Unknown error: ' . \json_encode($response), $response['code']);
        }

        $errorClass = new $this->statuses[$response['code']]['class'](
            $this->statuses[$response['code']]['message'],
            $response['code']
        );

        throw $errorClass;
    }
}
