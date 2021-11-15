<?php

namespace Omnipay\Tinkoff;

use JsonSerializable;

class Items implements JsonSerializable
{
    protected $items = [];

    public function __construct($items = [])
    {
        array_push($this->items, ...$items);
    }

    public function add($item)
    {
        $this->items[] = $item;
    }

    public function jsonSerialize()
    {
        $result = [];

        foreach ($this->items as $item) {
            /**
             * @var Item $item
             */

            if ($item instanceof JsonSerializable) {
                $result[] = $item->jsonSerialize();
            } else {
                $result[] = $item;
            }
        }

        return $result;
    }
}
