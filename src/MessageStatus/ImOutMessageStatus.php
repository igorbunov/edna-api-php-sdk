<?php

namespace igorbunov\Edna\MessageStatus;

class ImOutMessageStatus
{
    public $imOutMessageId;
    public $dlvStatus;
    public $dlvStatusAt;
    public $dlvError;
    public $code;
    public $dlvStatusText;

    protected $statusTexts = [
        'cancelled' => 'отправка сообщения отменена',
        'delivered' => 'сообщение доставлено адресату',
        'delayed' => 'отправка сообщения отложена',
        'enqueued' => 'сообщение находится в очереди на отправку',
        'expired' => 'сообщение не получило статус delivered за период указанный в сообщении, либо не получило статус delivered в течении 24 часов с момента отправки',
        'failed' => 'сообщение не было отправлено в результат сбоя',
        'no-match-template' => 'сообщение не соответствует допустимому шаблону',
        'read' => 'сообщение прочитано адресатом',
        'sent' => 'сообщение отправлено адресату',
        'undelivered' => 'сообщение отправлено, но не доставлено адресату',
    ];

    public function __construct(array $response)
    {
        $this->imOutMessageId = $response['imOutMessageId'];
        $this->dlvStatus = $response['dlvStatus'];
        $this->dlvStatusAt = $response['dlvStatusAt'];
        $this->dlvError = $response['dlvError'] ?? '';
        $this->code = $response['code'] ?? '';
        $this->dlvStatusText = $this->statusTexts[$this->dlvStatus] ?? 'Статус неизвестен';
    }
}