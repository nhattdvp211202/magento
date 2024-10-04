<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Model;

class Rule extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Rule's Statuses
     */
    const STATUS_ENABLED = 1;
    /**
     *
     */
    const STATUS_DISABLED = 0;
    /**
     *
     */
    const CUSTOMER_GROUP_GENERAL = 1;
    /**
     *
     */
    const CUSTOMER_GROUP_WHOLESALE = 2;
    /**
     *
     */
    const CUSTOMER_GROUP_RETAILER = 3;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule');
    }

    /**
     * Prepare rule's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    public function getAvailableCustoemrGroup()
    {
        return [self::CUSTOMER_GROUP_GENERAL => __('General'), self::CUSTOMER_GROUP_WHOLESALE => __('Wholesale'), self::CUSTOMER_GROUP_RETAILER => __('Retailer')];
    }
}
