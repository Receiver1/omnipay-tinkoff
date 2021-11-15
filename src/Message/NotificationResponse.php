<?php

namespace Omnipay\Tinkoff\Message;

class NotificationResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getRequest()->isValid();
    }
}
