<?php

namespace Omnipay\Tinkoff\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tinkoff\PaymentInterface;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {
    const SIGNATURE_KEYS_TO_SKIP = [];

    protected $liveEndpoint = 'https://securepay.tinkoff.ru/v2/';

    public function getTerminalId() {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId($value) {
        return $this->setParameter('terminalId', $value);
    }

    public function getPassword() {
        return $this->getParameter('password');
    }

    public function setPassword($value) {
        return $this->setParameter('password', $value);
    }

    public function getPayment(): PaymentInterface {
        return $this->getParameter('payment');
    }

    public function setPayment($payment) {
        if (!$payment instanceof PaymentInterface) {
            throw new InvalidRequestException('Only PaymentInterface is supported');
        }

        $this
            ->setAmount($payment->getAmount())
            ->setCurrency($payment->getCurrency())
            ->setDescription($payment->getDescription())
            ->setReturnUrl($payment->getReturnUrl())
            ->setTransactionId($payment->getTransactionId())
            ->setTransactionReference($payment->getTransactionReference());

        return $this->setParameter('payment', $payment);
    }

    protected function getEndpoint() {
        return $this->liveEndpoint;
    }

    protected function getSignature($data) {
        $data["Password"] = $this->getPassword();

        ksort($data);

        $tokenStr = '';

        foreach ($data as $key => $value) {
            if (in_array($key, static::SIGNATURE_KEYS_TO_SKIP)) {
                continue;
            }

            $tokenStr .= is_bool($value) ? ($value ? "true" : "false") : $value;
        }

        return hash("sha256", $tokenStr);
    }

    abstract protected function getMethod();
}
