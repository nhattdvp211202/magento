<?php

namespace Tigren\CustomerGroupCatalog\Block\History;

use Magento\Framework\View\Element\Template;

class RuleInfo extends Template
{
    protected $ruleFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Tigren\CustomerGroupCatalog\Model\RuleFactory $ruleFactory,
        array $data = []
    ) {
        $this->ruleFactory = $ruleFactory;
        parent::__construct($context, $data);
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }
    public function getRuleId()
    {
        $id = $this->getRequest()->getParam('rule_id');
        return $id;
    }
    public function getRuleInfo()
    {
        $ruleId = $this->getRuleId();
        if ($ruleId) {
            // Lấy collection và lọc theo rule_id
            $collection = $this->ruleFactory->create()->getCollection();
            $collection->addFieldToFilter('rule_id', $ruleId);

            // Nếu collection không rỗng, trả về đối tượng đầu tiên
            if ($collection->getSize() > 0) {
                return $collection->getFirstItem(); // Trả về đối tượng quy tắc đầu tiên
            }
        }
        return null; // Trả về null nếu không tìm thấy quy tắc
    }
}
