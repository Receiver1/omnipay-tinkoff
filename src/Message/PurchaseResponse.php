<?php


namespace Omnipay\Tinkoff\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface {
    public function isSuccessful() {
        return boolval($this->data['Success']);
    }

    public function isRedirect() {
        return true;
    }

    public function getRedirectUrl() {
        return $this->data['PaymentURL'];
    }

    public function getRedirectMethod() {
        return 'GET';
    }

    public function getTransactionReference() {
        return isset($this->data['PaymentId']) ? intval($this->data['PaymentId']) : null;
    }

    public function getTransactionId() {
        return isset($this->data['OrderId']) ? intval($this->data['OrderId']) : null;
    }

    public function getMessage() {
        return isset($this->data['Message']) ? $this->data['Message'] : null;
    }

    public function getDetailMessage() {
        return isset($this->data['DetailMessage']) ? $this->data['DetailMessage'] : null;
    }

    public function getCode() {
        return isset($this->data['ErrorCode']) ? intval($this->data['ErrorCode']) : null;
    }
}
