<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Block\History;

use Magento\Framework\View\Element\Template;

class RuleInfo extends Template
{
    /**
     * @var \Tigren\CustomerGroupCatalog\Model\RuleFactory
     */
    protected $ruleFactory;

    /**
     * @param Template\Context $context
     * @param \Tigren\CustomerGroupCatalog\Model\RuleFactory $ruleFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Tigren\CustomerGroupCatalog\Model\RuleFactory   $ruleFactory,
        array                                            $data = []
    )
    {
        $this->ruleFactory = $ruleFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return $this|RuleInfo
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRuleId()
    {
        $id = $this->getRequest()->getParam('rule_id');
        return $id;
    }

    /**
     * @return null
     */
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
