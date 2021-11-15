<?php

namespace Omnipay\Tinkoff\Message;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        return $this->data['Success'];
    }

    public function getTransactionReference()
    {
        if (isset($this->data['PaymentId'])) {
            return $this->data['PaymentId'];
        }

        return null;
    }

    public function getTransactionId()
    {
        if (isset($this->data['OrderId'])) {
            return $this->data['OrderId'];
        }

        return null;
    }

    public function getMessage()
    {
        if (isset($this->data['Message'])) {
            return $this->data['Message'];
        }

        return null;
    }

    public function getDetailMessage()
    {
        if (isset($this->data['DetailMessage'])) {
            return $this->data['DetailMessage'];
        }

        return null;
    }

    public function getCode()
    {
        if (isset($this->data['Error'])) {
            return $this->data['Error'];
        }

        return null;
    }
}
