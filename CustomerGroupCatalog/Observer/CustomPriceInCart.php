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
            ->addFieldToFilter('start_time', ['lteq' => date('Y-m-d H:i:s')])
            ->addFieldToFilter('end_time', ['gteq' => date('Y-m-d H:i:s')])
            ->addFieldToFilter('active', 1)
            ->setOrder('priority', 'ASC');

        $rule = $ruleCollection->getFirstItem();

        if ($rule && $rule->getId()) {
            if ($this->checkRuleApplicability($rule, $item)) {
                $discountAmount = $this->calculateDiscount($rule, $item->getPrice());
                $discountedPrice = $item->getPrice() - $discountAmount;

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
