<?php

namespace Tigren\Testimonial\Model\Testimonial\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{

    protected $testimonial;

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
