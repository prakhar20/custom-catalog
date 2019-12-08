<?php
namespace Altayer\CustomCatalog\Model;
use Altayer\CustomCatalog\Api\CustomCatalogApiInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Altayer\CustomCatalog\Api\SyncDataInterface;
class CustomCatalogApi implements CustomCatalogApiInterface
{

    protected $_pageFactory;
    protected $data;
    public function __construct(
        
        PublisherInterface $publisher,
        SyncDataInterface $dataSetter
        )
    {
        
        $this->publisher = $publisher;
        $this->dataSetter = $dataSetter;
    }

    /**
     * Responsed with the status message
     *
     * @api
     * @param string $name Product name.
     * @return string Status Message.
     */

    public function setcustomcatalog($entity_id,$copy_writeinfo,$vpn)
    {
    	
        if($entity_id)
        {

        $data = [
                    'entity_id' => $entity_id,
                    'copy_writeinfo' => $copy_writeinfo,
                    'vpn' => $vpn,
                ]; 
        return "Product Saved. Catalog/Product will also be updated if the SKU exists";
        
        
        
        $this->dataSetter->setData(json_encode($data));
        $this->publisher->publish('customCatalog', $this->dataSetter);
        }
        else
        {
            return  "Entity Id Cant Be Blank, Please provide id";
        }
    }
}