<?php
namespace Altayer\CustomCatalog\Ui\Component\Listing\DataProviders\Customcatalog;


/**
 * Class Grid
 */
class Grid extends \Magento\Ui\DataProvider\AbstractDataProvider
{    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
