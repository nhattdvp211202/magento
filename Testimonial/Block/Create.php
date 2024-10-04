<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session as CustomerSession;

class Create extends Template
{
    protected $customerSession;

    public function __construct(
        Context         $context,
        CustomerSession $customerSession,
        array           $data = []
    )
    {
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getCustomerName()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomer()->getName();
        }
        return null;
    }

    public function getCustomerEmail()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomer()->getEmail();
        }
        return null;
    }

    public function getFormAction()
    {
        return $this->getUrl('testimonial/index/save');
    }
}
