<?php

namespace Omnipay\Tinkoff\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const SIGNATURE_KEYS_TO_SKIP = [];

    protected $liveEndpoint = 'https://securepay.tinkoff.ru/v2/';

    public function getTerminalId()
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId($value)
    {
        return $this->setParameter('terminalId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    protected function getEndpoint()
    {
        return $this->liveEndpoint;
    }

    protected function getSignature($data)
    {
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
