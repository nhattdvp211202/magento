<?php

namespace Tigren\Testimonial\Model\ResourceModel;

class Testimonial extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('testimonial', 'id');
    }
}
