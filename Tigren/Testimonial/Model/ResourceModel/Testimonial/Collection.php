<?php

namespace Tigren\Testimonial\Model\ResourceModel\Testimonial;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Tigren\Testimonial\Model\Testimonial', 'Tigren\Testimonial\Model\ResourceModel\Testimonial');
    }
}
