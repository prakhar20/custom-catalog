<?php
/**
 * @category   Tryout
 * @package    Tryout_CustomCatalog
 * @author     sam.demo@gmail.com
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