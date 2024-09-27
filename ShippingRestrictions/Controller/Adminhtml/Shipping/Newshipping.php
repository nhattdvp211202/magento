<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Controller\Adminhtml\Shipping;

class Newshipping extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Tigren_ShippingRestrictions::shipping');
        $id = $this->getRequest()->getParam('id');
        if (!empty($id)) {
            $resultPage->getConfig()->getTitle()->prepend((__('Edit Shipping Restriction')));
        } else {
            $resultPage->getConfig()->getTitle()->prepend((__('Add New Shipping Restriction')));
        }


        return $resultPage;
    }
}
