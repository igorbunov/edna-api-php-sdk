<?php

namespace igorbunov\Edna\Message;

class ImOutMessage
{
    protected const CONTENT_TYPE_TEXT = 'text';
    protected const CONTENT_TYPE_IMAGE = 'image';
    protected const CONTENT_TYPE_DOCUMENT = 'document';
    protected const CONTENT_TYPE_VIDEO = 'video';
    protected const CONTENT_TYPE_LOCATION = 'location';

    protected const IM_TYPE_WHATSAPP = 'whatsapp';
    protected const IM_TYPE_VIBER = 'viber';
    protected const IM_TYPE_VK = 'vk';

    protected const PRIORITY_REALTIME = 'realtime';
    protected const PRIORITY_HIGHT = 'high';
    protected const PRIORITY_NORMAL = 'normal';
    protected const PRIORITY_LOW = 'low';

    protected $contentType;
    protected $address;
    protected $messageId;
    protected $text;
    protected $imType;
    protected $subject;
    protected $priority;
    protected $validityPerSeconds;
    protected $startTime;
    protected $comment;
    protected $caption;
    protected $locationAddress;
    protected $longitude;
    protected $latitude;
    protected $attachmentUrl;
    protected $attachmentName;

    public function __construct()
    {
        $this->priority = self::PRIORITY_NORMAL;
        $this->imType = self::IM_TYPE_WHATSAPP;
        $this->contentType = self::CONTENT_TYPE_TEXT;
        $this->messageId = md5(uniqid() . date('Y-m-d H:i:s'));
    }

    public function contentType(string $type)
    {
        $this->contentType = $type;

        return clone $this;
    }

    public function address(string $address)
    {
        $this->address = $address;

        return clone $this;
    }

    public function messageId(string $messageId)
    {
        $this->messageId = $messageId;

        return clone $this;
    }

    public function text(string $text)
    {
        $this->text = $text;
        $this->contentType = 'text';

        return clone $this;
    }

    public function subject(string $subject)
    {
        $this->subject = $subject;

        return clone $this;
    }

    public function priority(string $priority)
    {
        $this->priority = $priority;

        return clone $this;
    }

    public function validityPeriodSeconds(int $validityPerSeconds)
    {
        $this->validityPerSeconds = $validityPerSeconds;

        return clone $this;
    }

    public function startTime(string $dateTime)
    {
        $this->startTime = $dateTime;

        return clone $this;
    }

    public function attachmentName(string $attachmentName)
    {
        $this->attachmentName = $attachmentName;

        return clone $this;
    }

    public function attachmentUrl(string $attachmentUrl)
    {
        $this->attachmentUrl = $attachmentUrl;

        return clone $this;
    }

    public function latitude(string $latitude)
    {
        $this->latitude = $latitude;

        return clone $this;
    }

    public function longitude(string $longitude)
    {
        $this->longitude = $longitude;

        return clone $this;
    }

    public function locationAddress(string $locationAddress)
    {
        $this->locationAddress = $locationAddress;

        return clone $this;
    }

    public function caption(string $caption)
    {
        $this->caption = $caption;

        return clone $this;
    }

    public function comment(string $comment)
    {
        $this->comment = $comment;

        return clone $this;
    }

    public function toArray(): array
    {
        $result = [
            "id" => $this->messageId,
            "subject" => $this->subject,
            "address" => $this->address,
            "imType" => $this->imType,
            "contentType" => $this->contentType,
            "text" => $this->text,
        ];

        if (!empty($this->startTime)) {
            $result["startTime"] = $this->startTime;
        }

        if (!empty($this->validityPerSeconds)) {
            $result["validityPerSeconds"] = $this->validityPerSeconds;
        }

        if (!empty($this->priority)) {
            $result["priority"] = $this->priority;
        }

        if (!empty($this->comment)) {
            $result["comment"] = $this->comment;
        }

        if (!empty($this->caption)) {
            $result["caption"] = $this->caption;
        }

        if (!empty($this->locationAddress)) {
            $result["locationAddress"] = $this->locationAddress;
        }

        if (!empty($this->longitude)) {
            $result["longitude"] = $this->longitude;
        }

        if (!empty($this->latitude)) {
            $result["latitude"] = $this->latitude;
        }

        if (!empty($this->attachmentUrl)) {
            $result["attachmentUrl"] = $this->attachmentUrl;
        }

        if (!empty($this->attachmentName)) {
            $result["attachmentName"] = $this->attachmentName;
        }

        return $result;
    }
}
