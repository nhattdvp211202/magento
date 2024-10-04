<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\ShippingRestrictions\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\ResourceConnection;

class CustomerRule implements OptionSourceInterface
{
    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        // Lấy kết nối đến cơ sở dữ liệu
        $connection = $this->resourceConnection->getConnection();

        // Lấy tên bảng salesrule
        $table = $this->resourceConnection->getTableName('salesrule');

        // Tạo truy vấn để lấy id và tên của Sales Rule
        $select = $connection->select()->from($table, ['rule_id', 'name']);

        // Thực hiện truy vấn
        $salesRules = $connection->fetchAll($select);

        // Tạo mảng options để trả về
        $options = [];
        foreach ($salesRules as $rule) {
            $options[] = [
                'value' => $rule['rule_id'],   // Giá trị sẽ là rule_id
                'label' => $rule['name']       // Nhãn sẽ là tên của Sales Rule
            ];
        }

        return $options;
    }
}
