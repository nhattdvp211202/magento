<?php

namespace Tigren\MagentoJS\Block;

use Magento\Framework\View\Element\Template;

class Example extends Template
{
    public function getJsLayout()
    {
        return json_encode([
            'message' => 'Welcome to Tigren Clothings!'
        ]);
    }
}
