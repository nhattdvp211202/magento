<?php

namespace Tigren\Testimonial\Model;

class Testimonial extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Testimonial's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected function _construct()
    {
        $this->_init('Tigren\Testimonial\Model\ResourceModel\Testimonial');
    }

    /**
     * Prepare testimonial's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
