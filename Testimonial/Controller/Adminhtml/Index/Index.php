<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Tigren_Testimonial::testimonial_manager';

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // Load layout and set active menu
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Tigren_Testimonial::testimonial_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Testimonial manager'));

        return $resultPage;
    }
}
