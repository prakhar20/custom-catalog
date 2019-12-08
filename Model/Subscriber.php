<?php
namespace Altayer\CustomCatalog\Model;
use Magento\Framework\Model\AbstractModel;
use Altayer\CustomCatalog\Api\SyncDataInterface;
use Altayer\CustomCatalog\Api\SubscriberInterface;
use Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog\CollectionFactory;
use Magento\Catalog\Model\Product;

class Subscriber implements SubscriberInterface
{

    protected $_collectionFactory;
    protected $_productModel;

    public function __construct(
        CollectionFactory $collectionFactory,
        Product $product
    )
    {
        $this->collectionFactory =  $collectionFactory;
        $this->_productModel = $product;
    }

    public function proceed(SyncDataInterface $data)
    {
    	$r = json_decode($data->getData(),true);
        extract($r);

        if(empty($entity_id))
            return  "Entity Id Cant Be Blank, Please provide id";

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->_productModel = $objectManager->create('Magento\Catalog\Model\Product');    
        $entity = $this->_productModel->load($entity_id);
        $record = $this->collectionFactory->create()->addFieldToFilter('sku',$entity->getSku())->getFirstItem();
        $record->setVpn($vpn);
        $record->setCopyWriteInfo($copy_writeinfo);
        try
        {
            $record->save();
            try
            {
                $loadedProduct  =  $this->_productModel->load('sku',$record->getSku());
                $loadedProduct->setStoreId(0);
                $loadedProduct->setVpn($vpn);
                $loadedProduct->setCopyWriteInfo($copy_writeinfo);
                $loadedProduct->save();    
            }
            catch(Exception $e)
            {
                return "Product Saved. Catalog/Product not updated as the sku of the product doesnt exist in main catalog";
            }
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    	
    }
}