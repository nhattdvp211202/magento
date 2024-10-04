<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Model;

use Magento\Framework\Model\AbstractModel;

class RuleHistory extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Tigren\CustomerGroupCatalog\Model\ResourceModel\RuleHistory::class);
    }
}
