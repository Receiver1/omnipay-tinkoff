<?php

namespace Omnipay\Tinkoff\Message;

use Omnipay\Common\Message\AbstractResponse;

class NotificationResponse extends AbstractResponse {
    public function isSuccessful() {
        return $this->getRequest()->isValid();
    }
}
