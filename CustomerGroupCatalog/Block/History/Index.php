<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Block\History;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory
     */
    protected $ruleHistoryFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory $ruleHistoryFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory $ruleHistoryFactory,
        array $data = []
    ) {
        $this->ruleHistoryFactory = $ruleHistoryFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getRuleHistory()
    {
        $collection = $this->ruleHistoryFactory->create()->getCollection();
        return $collection;
    }
}
