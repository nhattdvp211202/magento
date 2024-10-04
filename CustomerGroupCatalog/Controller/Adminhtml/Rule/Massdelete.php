<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

class Massdelete extends \Magento\Backend\App\Action
{
    /**
     * @var bool|\Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory = false;
    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * @var Filter
     */
    public $filter;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param RuleFactory $ruleFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Filter                                     $filter,
        CollectionFactory                          $collectionFactory,
        RuleFactory                                $ruleFactory
    )
    {
        parent::__construct($context);
        $this->ruleFactory = $ruleFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|(\Magento\Framework\Controller\Result\Redirect&\Magento\Framework\Controller\ResultInterface)|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParams();
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;

            foreach ($collection as $model) {
                $model = $this->ruleFactory->create()->load($model->getId());
                $model->delete();
                $count++;
            }

            $this->messageManager->addSuccess(__('A total of %1 rule(s) have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
