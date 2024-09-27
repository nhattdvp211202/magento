<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Shipping\Model\Config as ShippingConfig;

class ShippingMethods implements OptionSourceInterface
{
    protected $shippingConfig;

    public function __construct(ShippingConfig $shippingConfig)
    {
        $this->shippingConfig = $shippingConfig;
    }

    public function toOptionArray()
    {
        $methods = $this->shippingConfig->getActiveCarriers();
        $options = [];

        foreach ($methods as $code => $method) {
            $options[] = [
                'value' => $code,
                'label' => $method->getConfigData('title')
            ];
        }

        return $options;
    }
}
