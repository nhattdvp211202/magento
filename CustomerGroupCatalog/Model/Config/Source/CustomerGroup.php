<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\ResourceConnection;

class CustomerGroup implements OptionSourceInterface
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
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('customer_group');
        $select = $connection->select()->from($table, ['customer_group_code', 'customer_group_id']);
        $categories = $connection->fetchAll($select);

        $options = [];
        foreach ($categories as $category) {
            $options[] = [
                'value' => $category['customer_group_id'],
                'label' => $category['customer_group_code']
            ];
        }

        return $options;
    }
}
