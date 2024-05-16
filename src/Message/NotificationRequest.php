<?php

namespace Omnipay\Tinkoff\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\NotificationInterface;

class NotificationRequest extends AbstractRequest implements NotificationInterface {
    const SIGNATURE_KEYS_TO_SKIP = [
        "Token",
    ];

    const NOTIFICATION_STATUS_AUTHORIZED = "AUTHORIZED";
    const NOTIFICATION_STATUS_CONFIRMED = "CONFIRMED";
    const NOTIFICATION_STATUS_REVERSED = "REVERSED";
    const NOTIFICATION_STATUS_REFUNDED = "REFUNDED";
    const NOTIFICATION_STATUS_PARTIAL_REFUNDED = "PARTIAL_REFUNDED";
    const NOTIFICATION_STATUS_REJECTED = "REJECTED";

    public function isValid(): bool {
        return $this->getSignature($this->getData()) === $this->getData()['Token'];
    }

    public function getData() {
        $body = $this->httpRequest->getContent();

        return json_decode($body, true);
    }

    public function getTransactionStatus() {
        $status = $this->getData()['Status'];

        switch ($status) {
            case self::NOTIFICATION_STATUS_AUTHORIZED:
                return NotificationInterface::STATUS_PENDING;
            case self::NOTIFICATION_STATUS_CONFIRMED:
                return NotificationInterface::STATUS_COMPLETED;
            case self::NOTIFICATION_STATUS_REVERSED:
            case self::NOTIFICATION_STATUS_REFUNDED:
            case self::NOTIFICATION_STATUS_PARTIAL_REFUNDED:
            case self::NOTIFICATION_STATUS_REJECTED:
            default:
                return $status;
        }
    }

    public function getMessage() {
        return null;
    }

    public function sendData($data) {
        try {
            return $this->response = new NotificationResponse($this, $data);
        } catch (\Throwable $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    protected function getMethod() {
        return null;
    }
}
