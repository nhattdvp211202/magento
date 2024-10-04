<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Controller\History;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory
     */
    protected $ruleHistoryFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory $ruleHistoryFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context                 $context,
        \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory $ruleHistoryFactory,
        \Magento\Framework\View\Result\PageFactory            $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->ruleHistoryFactory = $ruleHistoryFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Rule History'));

        return $resultPage;
    }
}
