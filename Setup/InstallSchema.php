<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2015 - 2019 Pulse Storm LLC, Alan Storm
 * 
 * Permission is hereby granted, free of charge, to any person obtaining 
 * a copy of this software and associated documentation files (the 
 * "Software"), to deal in the Software without restriction, including 
 * without limitation the rights to use, copy, modify, merge, publish, 
 * distribute, sublicense, and/or sell copies of the Software, and to 
 * permit persons to whom the Software is furnished to do so, subject to 
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included 
 * in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS 
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF 
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY 
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT 
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR 
 * THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Altayer\CustomCatalog\Setup;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();
		if (!$installer->tableExists('altayer_customcatalog')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('altayer_customcatalog')
			)
			->addColumn(
				'catalog_product_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'identity' => true,
					'nullable' => false,
					'primary' => true,
					'unsigned' => true,
				],
				'Custom Catalog Product Id(AI)'
			)
			->addColumn(
				'product_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				['nullable => false'],
				'Magento Catalog Product ID'
			)
			->addColumn(
				'sku',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[],
				'SKU of the product'
			)
			->addColumn(
				'copy_write_info',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'',
				[],
				'Copy Write Info'
			)
			->addColumn(
				'vpn',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'255',
				[],
				'Vendor Product Number'
			);
			$installer->getConnection()->createTable($table);
			$installer->getConnection()->addIndex(
				$installer->getTable('altayer_customcatalog'),
				$setup->getIdxName(
					$installer->getTable('altayer_customcatalog'),
					['product_id', 'sku', 'copy_write_info', 'vpn'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['product_id', 'sku', 'copy_write_info', 'vpn'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}
