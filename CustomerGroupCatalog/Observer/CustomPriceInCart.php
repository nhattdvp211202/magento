<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote\Item;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;

class CustomPriceInCart implements ObserverInterface
{
    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * Constructor
     *
     * @param RuleCollectionFactory $ruleCollectionFactory
     */
    public function __construct(
        RuleCollectionFactory $ruleCollectionFactory
    )
    {
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }

    /**
     * Execute observer method
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var Item $item */
        $item = $observer->getEvent()->getData('quote_item');
        $item = $item->getParentItem() ? $item->getParentItem() : $item;

        // Get customer group ID and product ID
        $customerGroupId = $item->getQuote()->getCustomerGroupId();
        $productId = $item->getProductId();

        // Load rules from collection
        $ruleCollection = $this->ruleCollectionFactory->create()
            ->addFieldToFilter('products', $productId)
            ->addFieldToFilter('customer_group', $customerGroupId)
            ->addFieldToFilter('active', 1)
            ->setOrder('priority', 'ASC'); // Lấy rule có độ ưu tiên cao nhất trước

        $currentTime = date('Y-m-d H:i:s');

        /** @var \Tigren\CustomerGroupCatalog\Model\Rule $applicableRule */
        $applicableRule = null;

        // Duyệt qua tất cả các rule và chỉ lấy rule đầu tiên có thời gian hợp lệ
        foreach ($ruleCollection as $rule) {
            if ($rule->getStartTime() <= $currentTime && $rule->getEndTime() >= $currentTime) {
                $applicableRule = $rule;
                break;
            }
        }

        // Nếu tìm thấy rule hợp lệ
        if ($applicableRule && $applicableRule->getId()) {
            if ($this->checkRuleApplicability($applicableRule, $item)) {
                $discountAmount = $this->calculateDiscount($applicableRule, $item->getPrice());
                $discountedPrice = $item->getPrice() - $discountAmount;

                // Áp dụng giá giảm cho item
                $item->setCustomPrice($discountedPrice);
                $item->setOriginalCustomPrice($discountedPrice);
                $item->getProduct()->setIsSuperMode(true);
            }
        }
    }


    /**
     * Check rule applicability
     *
     * @param $rule
     * @param Item $item
     * @return bool
     */
    protected function checkRuleApplicability($rule, $item)
    {
        // Custom logic to check if rule is applicable to the item
        return true;
    }

    /**
     * Calculate discount based on rule data
     *
     * @param $rule
     * @param float $price
     * @return float
     */
    protected function calculateDiscount($rule, $price)
    {
        $discountPercentage = $rule->getDiscountAmount() ?: 0;
        return ($price * $discountPercentage) / 100;
    }
}
