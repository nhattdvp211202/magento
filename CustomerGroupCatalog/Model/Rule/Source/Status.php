<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Model\Rule\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{

    /**
     * @var \Tigren\CustomerGroupCatalog\Model\Rule
     */
    protected $rule;

    /**
     * @param \Tigren\CustomerGroupCatalog\Model\Rule $rule
     */
    public function __construct(\Tigren\CustomerGroupCatalog\Model\Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->rule->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
