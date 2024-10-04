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
use Tigren\CustomerGroupCatalog\Model\ResourceModel\RuleHistory as RuleHistoryResource;
use Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory;
use Magento\Sales\Model\Order;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;

/**
 *
 */
class SaveRuleHistory implements ObserverInterface
{
    /**
     * @var RuleHistoryFactory
     */
    protected $ruleHistoryFactory;

    /**
     * @var RuleHistoryResource
     */
    protected $ruleHistoryResource;

    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * Constructor
     *
     * @param RuleHistoryFactory $ruleHistoryFactory
     * @param RuleHistoryResource $ruleHistoryResource
     * @param RuleCollectionFactory $ruleCollectionFactory
     */
    public function __construct(
        RuleHistoryFactory $ruleHistoryFactory,
        RuleHistoryResource $ruleHistoryResource,
        RuleCollectionFactory $ruleCollectionFactory
    ) {
        $this->ruleHistoryFactory = $ruleHistoryFactory;
        $this->ruleHistoryResource = $ruleHistoryResource;
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
        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();

        // Lấy Order ID và Customer ID
        $orderId = $order->getIncrementId();
        $customerId = $order->getCustomerId();

        // Lấy danh sách các quy tắc áp dụng cho sản phẩm trong đơn hàng
        $appliedRules = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $productId = $item->getProductId();
            $ruleId = $this->getAppliedRuleIdForProduct($productId);
            if ($ruleId) {
                $appliedRules[] = $ruleId;
            }
        }

        // Lưu thông tin quy tắc đã áp dụng vào bảng tigren_history_rule
        foreach (array_unique($appliedRules) as $ruleId) {
            $ruleHistory = $this->ruleHistoryFactory->create();
            $ruleHistory->setData([
                'order_id' => $orderId,
                'customer_id' => $customerId,
                'rule_id' => $ruleId,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $this->ruleHistoryResource->save($ruleHistory);
        }
    }

    /**
     * Get applied rule ID for product
     *
     * @param int $productId
     * @return int|null
     */
    private function getAppliedRuleIdForProduct($productId)
    {
        $currentTime = date('Y-m-d H:i:s');

        // Lấy các quy tắc đang active và có sản phẩm trong danh sách
        $ruleCollection = $this->ruleCollectionFactory->create()
            ->addFieldToFilter('active', 1)
            ->addFieldToFilter('products', ['finset' => $productId])
            ->addFieldToFilter('start_time', ['lteq' => $currentTime])
            ->addFieldToFilter('end_time', ['gteq' => $currentTime])
            ->setOrder('priority', 'ASC')
            ->setPageSize(1);

        $rule = $ruleCollection->getFirstItem();

        if ($rule && $rule->getId()) {
            return $rule->getId();
        }

        return null;
    }
}
