<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Model\Testimonial\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{

    /**
     * @var \Tigren\Testimonial\Model\Testimonial
     */
    protected $testimonial;

    /**
     * @param \Tigren\Testimonial\Model\Testimonial $testimonial
     */
    public function __construct(\Tigren\Testimonial\Model\Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->testimonial->getAvailableStatuses();
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
