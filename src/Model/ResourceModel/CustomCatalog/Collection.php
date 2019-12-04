<?php
namespace Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog;

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(
            \Altayer\CustomCatalog\Model\CustomCatalog::class,
            \Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog::class
        );
    }
}
