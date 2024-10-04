<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Block\History;

use Magento\Customer\Model\SessionFactory;
use Magento\TestFramework\Catalog\Model\Indexer\Category\Product\Action\Full;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory
     */
    protected $ruleHistoryFactory;
    protected $customerSessionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory $ruleHistoryFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory $ruleHistoryFactory,
        SessionFactory $customerSessionFactory,
        array $data = []
    ) {
        $this->ruleHistoryFactory = $ruleHistoryFactory;
        $this->customerSessionFactory = $customerSessionFactory;
        parent::__construct($context, $data);
    }

    public function getCustomerId()
    {
        $customerSession = $this->customerSessionFactory->create();
        return $customerSession->getCustomer()->getId();
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getRuleHistory()
    {
        $customerId = $this->getCustomerId();
        if ($customerId) {
            $collection = $this->ruleHistoryFactory->create()->getCollection();
            $collection->addFieldToFilter('customer_id', $customerId); // Giả sử bạn có trường customer_id trong bảng
            return $collection;
        }
        return []; // Trả về mảng rỗng nếu không có customer ID
    }
}
