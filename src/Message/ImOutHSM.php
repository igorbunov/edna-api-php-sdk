<?php

namespace igorbunov\Edna\Message;

use igorbunov\Edna\Message\ImOutMessage;

class ImOutHSM extends ImOutMessage
{
    protected const BUTTON_TYPE_TEXT = 'TEXT';
    protected const BUTTON_TYPE_URL = 'URL';
    protected const BUTTON_TYPE_PHONE = 'PHONE';
    protected const BUTTON_TYPE_QUICK_REPLY = 'QUICK_REPLY';

    protected $headerText;
    protected $headerImageUrl;
    protected $headerDocumentUrl;
    protected $headerDocumentName;
    protected $headerVideoUrl;
    protected $headerVideoName;
    protected $footer;
    protected $buttons = [];

    public function headerText(string $text)
    {
        $this->headerText = $text;

        return clone $this;
    }

    public function headerImage(string $imageUrl)
    {
        $this->headerImageUrl = $imageUrl;

        return clone $this;
    }

    public function headerDocument(string $documentUrl, string $documentName)
    {
        $this->headerDocumentUrl = $documentUrl;
        $this->headerDocumentName = $documentName;

        return clone $this;
    }

    public function headerVideo(string $videoUrl, string $videoName)
    {
        $this->headerVideoUrl = $videoUrl;
        $this->headerVideoName = $videoName;

        return clone $this;
    }

    public function footer(string $text)
    {
        $this->footer = $text;

        return clone $this;
    }

    public function addTextButton(string $buttonText)
    {
        $this->buttons[] = [
            "text" => $buttonText,
            "buttonType" => self::BUTTON_TYPE_TEXT
        ];

        return clone $this;
    }

    public function addPhoneButton(string $buttonText, string $phone)
    {
        $this->buttons[] = [
            "text" => $buttonText,
            "buttonType" => self::BUTTON_TYPE_PHONE,
            "phone" => $phone
        ];

        return clone $this;
    }

    public function addUrlButton(string $buttonText, string $url)
    {
        $this->buttons[] = [
            "text" => $buttonText,
            "buttonType" => self::BUTTON_TYPE_URL,
            "url" => $url
        ];

        return clone $this;
    }

    public function addQuickReplyButton(string $buttonText, string $payload)
    {
        $this->buttons[] = [
            "text" => $buttonText,
            "buttonType" => self::BUTTON_TYPE_QUICK_REPLY,
            "payload" => $payload
        ];

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

        if (!empty($this->headerText)) {
            $result["header"] = [
                'text' => $this->headerText
            ];
        } elseif (!empty($this->headerImageUrl)) {
            $result["header"] = [
                'imageUrl' => $this->headerImageUrl
            ];
        } elseif (!empty($this->headerDocumentUrl)) {
            $result["header"] = [
                "documentUrl" => $this->headerDocumentUrl,
                "documentName" => $this->headerDocumentName
            ];
        } elseif (!empty($this->headerVideoUrl)) {
            $result["header"] = [
                "videoUrl" => $this->headerVideoUrl,
                "videoName" => $this->headerVideoName
            ];
        }

        if (!empty($this->footer)) {
            $result["footer"] = [
                'text' => $this->footer
            ];
        }

        if (!empty($this->buttons)) {
            $result['keyboard'] = [
                'row' => [
                    'buttons' => []
                ]
            ];

            foreach ($this->buttons as $btn) {
                $btnRow = [
                    'text' => $btn['text'],
                    'buttonType' => $btn['buttonType']
                ];

                switch ($btn['buttonType']) {
                    case self::BUTTON_TYPE_URL:
                        $btnRow['url'] = $btn['url'];
                        break;
                    case self::BUTTON_TYPE_PHONE:
                        $btnRow['phone'] = $btn['phone'];
                        break;
                    case self::BUTTON_TYPE_QUICK_REPLY:
                        $btnRow['payload'] = $btn['payload'];
                        break;
                }

                $result['keyboard']['row']['buttons'][] = $btnRow;
            }
        }

        return $result;
    }
}
