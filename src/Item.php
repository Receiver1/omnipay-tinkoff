<?php

namespace Omnipay\Tinkoff;

use Omnipay\Common\Item as OmniItem;

class Item extends OmniItem implements \JsonSerializable
{
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    public function getPaymentObject()
    {
        return $this->getParameter('paymentMethod');
    }

    public function setPaymentObject($value)
    {
        return $this->setParameter('paymentObject', $value);
    }

    public function getTax()
    {
        return $this->getParameter('tax');
    }

    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
    }

    public function jsonSerialize()
    {
        $result = [];

        foreach ($this->getParameters() as $key => $value) {
            if ($value) {
                $result[ucfirst($key)] = $value;
            }
        }

        $result["Price"] = intval($result["Price"]) * 100;
        $result["Amount"] = $result["Price"] * intval($result["Quantity"]);

        return $result;
    }
}
