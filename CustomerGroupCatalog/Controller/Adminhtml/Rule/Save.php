<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Tigren\CustomerGroupCatalog\Model\RuleFactory;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;
use Magento\Backend\App\Action;

/**
 * Class Save
 */
class Save extends Action
{
    /**
     * @var RuleFactory
     */
    private $ruleFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Action\Context $context
     * @param RuleFactory $ruleFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Action\Context    $context,
        RuleFactory       $ruleFactory,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->ruleFactory = $ruleFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->messageManager->addErrorMessage(__('No data found to save.'));
            return $resultRedirect->setPath('*/*/');
        }

        // Lấy rule_id từ dữ liệu
        $id = !empty($data['rule_id']) ? $data['rule_id'] : null;

        // Tạo hoặc load bản ghi cần chỉnh sửa
        $rule = $this->ruleFactory->create();

        if ($id) {
            $rule->load($id);
        }

        try {
            $customerGroups = is_array($data['customer_group']) ? $data['customer_group'] : [$data['customer_group']];
            $products = is_array($data['products']) ? $data['products'] : [$data['products']];

            // Lưu từng nhóm khách hàng và sản phẩm
            foreach ($customerGroups as $customerGroup) {
                foreach ($products as $product) {
                    $newData = [
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'store' => $data['store'],
                        'discount_amount' => $data['discount_amount'],
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'customer_group' => $customerGroup,
                        'products' => $product,
                        'priority' => $data['priority'],
                        'active' => $data['active'],
                    ];

                    // Nếu đang chỉnh sửa, cập nhật dữ liệu cho bản ghi
                    if ($id) {
                        $rule->addData($newData);
                        $rule->save();
                    } else {
                        // Tạo mới bản ghi
                        $newRule = $this->ruleFactory->create();
                        $newRule->setData($newData);
                        $newRule->save();
                    }
                }
            }

            $this->messageManager->addSuccessMessage(__('You saved the rule.'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__($exception->getMessage()));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
