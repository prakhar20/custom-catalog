<?php
namespace Altayer\CustomCatalog\Model\ResourceModel;

/**
 * Class CustomCatalog
 */
class CustomCatalog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init('altayer_customcatalog', 'catalog_product_id');
    }
}
