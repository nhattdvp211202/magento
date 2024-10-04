<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;

class Logouthandles implements ObserverInterface
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @param CustomerSession $customerSession
     */
    public function __construct(CustomerSession $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $layout = $observer->getEvent()->getLayout();

        if (!$this->customerSession->isLoggedIn()) {
            $layout->getUpdate()->addHandle('customer_logged_view');
        }
    }
}
