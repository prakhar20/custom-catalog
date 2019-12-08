<?php
namespace Altayer\CustomCatalog\Observer;
use \Altayer\CustomCatalog\Model\CustomCatalog;
class CatalogProductDeleteAfter implements \Magento\Framework\Event\ObserverInterface
{
	protected $_customCatalog ;

    public function __construct(CustomCatalog $customCatalog)
    {
    	$this->_customCatalog = $customCatalog;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
    	
    	$product = $observer->getProduct();
    	$customProduct = $this->_customCatalog->load($product->getSku(),'sku');
    	$customProduct->delete();
    	
    }
}
