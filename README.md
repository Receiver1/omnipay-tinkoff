# Omnipay: Tinkoff

**Подержка эквайринга через Tinkoff для Omnipay**

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Установка

```bash
composer require league/omnipay omnipay/tinkoff
```

## Использование 
```php
// Создаём новый платёжный шлюз
$gateway = Omnipay::create('Tinkoff');

$gateway->setTerminalId('TerminalId');
$gateway->setPassword('TerminalPassword');

// Создаём новый платёж на сумму 10 руб. 00 коп. с идентификатором заказа 1234 
$request = $gateway->purchase([
  'amount' => 10,
  'orderId' => 1234,
  'description' => 'optional',
  'customerKey' => 'optional',
  'notificationUrl' => 'optional',
  'successUrl' => 'optional',
  'failUrl' => 'optional',
]);

$log->write(print_r($request->getData(), true));
$response = $request->send();

if (!$response->isSuccessful()) {
  $log->write($response->getDetailMessage());
  throw new Exception($response->getMessage());
}

$log->write(print_r($response->getData(), true));
return $response->gitRedirectUrl();
```
