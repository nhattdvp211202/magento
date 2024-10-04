<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ShippingMethods implements OptionSourceInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Lấy danh sách phương thức DHL từ cấu hình
     *
     * @return array
     */
    public function toOptionArray()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $shippingConfig = $objectManager->get('\Magento\Shipping\Model\Config');
        $activeCarriers = $shippingConfig->getActiveCarriers();

        $shippingMethods = [];
        foreach ($activeCarriers as $carrierCode => $carrierModel) {
            if ($carrierMethods = $carrierModel->getAllowedMethods()) {
                $carrierTitle = $this->scopeConfig->getValue('carriers/' . $carrierCode . '/title');
                foreach ($carrierMethods as $methodCode => $method) {
                    $code = $carrierCode . '_' . $methodCode;
                    $shippingMethods[] = ['value' => $code,
                        'label' => $carrierTitle . ' - ' . $method];
                }
            }
        }
        return $shippingMethods;
    }
}







