<?php

namespace Omnipay\Tinkoff;

interface PaymentInterface
{
    public function getProvider();

    public function getAmount();

    public function getCurrency();

    public function getDescription();

    public function getReturnUrl();

    public function getTransactionId();

    public function getTransactionReference();

    public function getItems();
}
