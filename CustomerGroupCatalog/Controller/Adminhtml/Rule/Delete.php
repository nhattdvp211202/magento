<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var bool|\Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory = false;
    /**
     * @var \Tigren\CustomerGroupCatalog\Model\RuleFactory
     */
    protected $ruleFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Tigren\CustomerGroupCatalog\Model\RuleFactory $ruleFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context            $context,
        \Magento\Framework\View\Result\PageFactory     $resultPageFactory,
        \Tigren\CustomerGroupCatalog\Model\RuleFactory $ruleFactory
    )
    {
        $this->ruleFactory = $ruleFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        // echo $id; exit;
        try {
            $model = $this->ruleFactory->create()->load($id);
            $model->delete();
            $this->messageManager->addSuccessMessage(__('You have deleted the rule.'));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the rule.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
