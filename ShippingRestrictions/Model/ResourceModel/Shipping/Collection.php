<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Model\ResourceModel\Shipping;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'rule_id';

    protected function _construct(): void
    {
        $this->_init(
            \Tigren\ShippingRestrictions\Model\Shipping::class,
            \Tigren\ShippingRestrictions\Model\ResourceModel\Shipping::class
        );
    }
}
