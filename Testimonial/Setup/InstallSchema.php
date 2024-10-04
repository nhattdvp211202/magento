<?php

namespace Tigren\Testimonial\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Create testimonial table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('testimonial')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'ID'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Email'
        )->addColumn(
            'message',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => false],
            'Message'
        )->addColumn(
            'company',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Company'
        )->addColumn(
            'rating',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '5'],
            'Rating'
        )->addColumn(
            'image',
            Table::TYPE_TEXT,
            255,
            [],
            'Image'
        )->addColumn(
            'status',
            Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false, 'default' => '1'],
            'Status'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true, 'unsigned' => true],
            'Customer ID'
        )->addForeignKey(
            $installer->getFkName('testimonial', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            Table::ACTION_SET_NULL
        )->setComment(
            'Testimonial Table'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
