<?php

namespace Tigren\Testimonial\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ResourceConnection;


class ReindexHelper extends AbstractHelper
{
    protected $_resource;

    public function __construct(
        Context $context,
        ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->_resource = $resource;
    }

    public function reindexIds()
    {
        $connection = $this->_resource->getConnection();
        $tableName = $connection->getTableName('testimonial');

        // Lấy tất cả các phần tử trong bảng, sắp xếp theo thứ tự hiện tại của ID
        $sql = "SELECT * FROM {$tableName} ORDER BY id";
        $items = $connection->fetchAll($sql);

        // Reset lại giá trị AUTO_INCREMENT về 1
        $sql = "ALTER TABLE {$tableName} AUTO_INCREMENT = 1";
        $connection->query($sql);

        // Gán lại ID cho từng phần tử
        foreach ($items as $key => $item) {
            $newId = $key + 1; // Tạo ID mới bắt đầu từ 1
            $connection->update(
                $tableName,
                ['id' => $newId],
                ['id = ?' => $item['id']]
            );
        }
    }
}
