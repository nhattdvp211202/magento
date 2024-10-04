<?php

namespace Tigren\Testimonial\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Create extends Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Create Testimonial'));
        $this->_view->renderLayout();
    }
}
