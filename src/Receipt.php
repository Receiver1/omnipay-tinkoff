<?php

namespace Omnipay\Tinkoff;

use JsonSerializable;
use Omnipay\Common\ParametersTrait;

class Receipt implements JsonSerializable
{
    use ParametersTrait;

    public function __construct($params = [])
    {
        $this->initialize($params);
    }

    public function jsonSerialize()
    {
        $result = [];

        foreach ($this->getParameters() as $key => $value) {
            if ($value) {
                if (is_object($value) && ($value instanceof JsonSerializable)) {
                    $result[ucfirst($key)] = $value->jsonSerialize();
                } else {
                    $result[ucfirst($key)] = $value;
                }
            }
        }

        return $result;
    }

    public function getEmail()
    {
        return $this->getParameter("email");
    }

    public function setEmail($value)
    {
        return $this->setParameter("email", $value);
    }

    public function getPhone()
    {
        return $this->getParameter("phone");
    }

    public function setPhone($value)
    {
        return $this->setParameter("phone", $value);
    }

    public function getEmailCompany()
    {
        return $this->getParameter("emailCompany");
    }

    public function setEmailCompany($value)
    {
        return $this->setParameter("emailCompany", $value);
    }

    public function getTaxation()
    {
        return $this->getParameter("taxation");
    }

    public function setTaxation($value)
    {
        return $this->setParameter("taxation", $value);
    }

    public function getItems()
    {
        return $this->getParameter("items");
    }

    public function setItems($value)
    {
        return $this->setParameter("items", $value);
    }
}
