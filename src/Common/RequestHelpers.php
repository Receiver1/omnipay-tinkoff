<?php

namespace Omnipay\Tinkoff\Common;

use Omnipay\Common\Message\AbstractRequest;

trait RequestHelpers
{
    public static $TRANSFORM_NONE = 0;
    public static $TRANSFORM_TOUPPER = 1;
    public static $TRANSFORM_TOLOWER = 2;
    public static $TRANSFORM_CAPITALIZE = 4;

    abstract protected function setParameter($key, $value);

    protected function setIfExists($key, $value, &$target = null, $transform = RequestHelpersInterface::TRANSFORM_NONE)
    {
        if ($value) {
            if (!$target || ($target instanceof AbstractRequest)) {
                $this->setParameter(
                    static::transform($key, $transform),
                    $value
                );
            } else {
                $target[static::transform($key, $transform)] = $value;
            }
        }

        return $this;
    }

    protected function setIfExistsArray($pairs, &$target = null, $transform = RequestHelpersInterface::TRANSFORM_NONE)
    {
        foreach ($pairs as $key => $value) {
            $this->setIfExists($key, $value, $target, $transform);
        }
    }

    protected static function transform($str, $transform = RequestHelpersInterface::TRANSFORM_NONE)
    {
        switch ($transform) {
            case RequestHelpersInterface::TRANSFORM_TOUPPER:
                return mb_strtoupper($str);
            case RequestHelpersInterface::TRANSFORM_TOLOWER:
                return mb_strtolower($str);
            case RequestHelpersInterface::TRANSFORM_CAPITALIZE:
                return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
        }

        return $str;
    }
}
