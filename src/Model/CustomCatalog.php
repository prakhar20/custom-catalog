<?php
namespace Altayer\CustomCatalog\Model;

/**
 * Class CustomCatalog
 */
class CustomCatalog extends \Magento\Framework\Model\AbstractModel implements
    \Altayer\CustomCatalog\Api\Data\CustomCatalogInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'altayer_customcatalog_customcatalog';

    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
