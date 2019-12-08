<?php
namespace Altayer\CustomCatalog\Observer;
use \Altayer\CustomCatalog\Model\CustomCatalog;
class CatalogProductSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
	protected $_customCatalog ;

    public function __construct(CustomCatalog $customCatalog)
    {
    	$this->_customCatalog = $customCatalog;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
    	
    	$product = $observer->getProduct();


    	$customProduct = $this->_customCatalog->load($product->getSku(),'sku');
    	if($customProduct->getId())
        {
        $customProduct->setVpn($product->getVpn());
    	$customProduct->setCopyWriteInfo($product->getCopyWriteInfo());
    	$customProduct->save();
        }
        else
        {
            $model = $this->_customCatalog;
            $model->setSku($product->getSku());
            $model->setVpn($product->getVpn());
            $model->setCopyWriteInfo($product->getCopyWriteInfo());
            $model->save();
        }   	
    }
}
