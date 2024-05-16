<?php


namespace Omnipay\Tinkoff\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface {
    public function isSuccessful(): bool {
        return boolval($this->data['Success']);
    }

    public function isRedirect(): bool {
        return true;
    }

    public function getRedirectUrl(): string {
        return $this->data['PaymentURL'];
    }

    public function getRedirectMethod(): string {
        return 'GET';
    }

    public function getTransactionReference(): int|null {
        return isset($this->data['PaymentId']) ? $this->data['PaymentId'] : null;
    }

    public function getTransactionId(): int|null {
        return isset($this->data['OrderId']) ? $this->data['OrderId'] : null;
    }

    public function getMessage(): string|null {
        return isset($this->data['Message']) ? $this->data['Message'] : null;
    }

    public function getDetailMessage(): string|null {
        return isset($this->data['DetailMessage']) ? $this->data['DetailMessage'] : null;
    }

    public function getCode(): int|null {
        return isset($this->data['ErrorCode']) ? $this->data['ErrorCode'] : null;
    }
}
