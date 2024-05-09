<?php

namespace Omnipay\Tinkoff\Message;

use DateTime;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tinkoff\Common\RequestHelpers;
use Throwable;

class PurchaseRequest extends AbstractRequest
{
    use RequestHelpers;

    const SIGNATURE_KEYS_TO_SKIP = [
        "DATA",
        "Receipt",
    ];

    protected function getMethod()
    {
        return "Init";
    }

    public function getData()
    {
        $data = [
            "TerminalKey" => $this->getTerminalId(),
            "Amount" => $this->getAmountInt(),
            "OrderId" => $this->getTransactionId(),
            "PayType" => $this->getTwoStagePaymentString(),
        ];

        $this->setIfExistsArray([
            "Description" => $this->getDescription(),
            "Language" => $this->getLanguage(),
            "CustomerKey" => $this->getCustomerKey(),
            "Recurrent" => $this->getRecurrent(),
            "RedirectDueDate" => $this->getRedirectDueDateObject(),
            "DATA" => $this->getExtraDataArray(),
            "NotificationURL" => $this->getNotificationUrl(),
            "SuccessURL" => $this->getSuccessUrl(),
            "FailURL" => $this->getFailUrl(),
            "Receipt" => $this->getReceipt(),
        ], $data);

        $signedData = array_merge($data, [
            "Token" => $this->getSignature($data),
        ]);

        return $signedData;
    }

    public function sendData($inputData)
    {
        try {
            $path = $this->getEndpoint();

            if ($this->getMethod()) {
                $path .= $this->getMethod();
            }

            $response = $this->httpClient->request("POST", $path, [
                "Content-Type" => "application/json",
            ], json_encode($inputData));

            $outputData = json_decode($response->getBody()->getContents(), true);

            return $this->response = new PurchaseResponse($this, $outputData);
        } catch (Throwable $e) {
            throw new InvalidRequestException('Failed to request purchase: ' . $e->getMessage(), 0, $e);
        }
    }

    protected function getAmountInt()
    {
        return ceil($this->getAmount() * 100);
    }

    public function getTransactionId()
    {
        return $this->getOrderId();
    }

    public function setTransactionId($value)
    {
        return $this->setOrderId($value);
    }

    public function getOrderId()
    {
        return $this->getParameter("orderId");
    }

    public function setOrderId($value)
    {
        return $this->setParameter("orderId", $value);
    }

    public function getLanguage()
    {
        return $this->getParameter("language");
    }

    public function setLanguage($value)
    {
        return $this->setParameter("language", $value);
    }

    public function getCustomerKey()
    {
        return $this->getParameter("customerKey");
    }

    public function setCustomerKey($value)
    {
        return $this->setParameter("customerKey", $value);
    }

    public function getRecurrent()
    {
        return $this->getParameter("recurrent");
    }

    public function setRecurrent($value)
    {
        return $this->setParameter("recurrent", $value);
    }

    public function getRecurrentString()
    {
        return $this->getRecurrent() ? "Y" : "N";
    }

    public function getRedirectDueDate()
    {
        return $this->getParameter("redirectDueDate");
    }

    public function setRedirectDueDate($value)
    {
        return $this->setParameter("redirectDueDate", $value);
    }

    public function getRedirectDueDateObject()
    {
        $date = $this->getRedirectDueDate();

        if (is_numeric($date)) {
            return (new DateTime())->setTimestamp(intval($date));
        } elseif (is_string($date)) {
            return (new DateTime())->setTimestamp(strtotime($date));
        } elseif ($date instanceof DateTime) {
            return $date;
        }

        return null;
    }

    public function getExtraData()
    {
        return $this->getParameter("extraData");
    }

    public function setExtraData($value)
    {
        return $this->setParameter("extraData", $value);
    }

    protected function getExtraDataArray()
    {
        $data = $this->getExtraData();

        if (is_object($data)) {
            return (array) $data;
        } elseif (is_array($data)) {
            return $data;
        } elseif (is_scalar($data)) {
            return [
                "value" => $data,
            ];
        }

        return null;
    }

    public function getNotificationUrl()
    {
        return $this->getParameter("notificationUrl");
    }

    public function setNotificationUrl($value)
    {
        return $this->setParameter("notificationUrl", $value);
    }

    public function getSuccessUrl()
    {
        return $this->getParameter("successUrl");
    }

    public function setSuccessUrl($value)
    {
        return $this->setParameter("successUrl", $value);
    }

    public function getFailUrl()
    {
        return $this->getParameter("failUrl");
    }

    public function setFailUrl($value)
    {
        return $this->setParameter("failUrl", $value);
    }

    public function getTwoStagePayment()
    {
        return $this->getParameter("twoStagePayment");
    }

    public function setTwoStagePayment($value)
    {
        return $this->setParameter("twoStagePayment", $value);
    }

    public function getTwoStagePaymentString()
    {
        return $this->getTwoStagePayment() ? "T" : "O";
    }

    public function getReceipt()
    {
        return $this->getParameter("receipt");
    }

    public function setReceipt($value)
    {
        return $this->setParameter("receipt", $value);
    }
}
