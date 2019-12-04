<?php
namespace Altayer\CustomCatalog\Model;

use Altayer\CustomCatalog\Api\CustomCatalogRepositoryInterface;
use Altayer\CustomCatalog\Api\Data\CustomCatalogInterface;
use Altayer\CustomCatalog\Model\CustomCatalogFactory;
use Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog as ObjectResourceModel;
use Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog\CollectionFactory;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Model\Product;

/**
 * Class CustomCatalogRepository
 */
class CustomCatalogRepository implements CustomCatalogRepositoryInterface
{
    protected $objectFactory;
    protected $objectResourceModel;
    protected $collectionFactory;
    protected $searchResultsFactory;
    protected $_productModel;

    /**
     * CustomCatalogRepository constructor.
     *
     * @param CustomCatalogFactory $objectFactory
     * @param ObjectResourceModel $objectResourceModel
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        CustomCatalogFactory $objectFactory,
        ObjectResourceModel $objectResourceModel,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        Product $product

    ) {
        $this->objectFactory        = $objectFactory;
        $this->objectResourceModel  = $objectResourceModel;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->_productModel =  $product;        
    }

    /**
     * @inheritDoc
     *
     * @throws CouldNotSaveException
     */
    public function save(CustomCatalogInterface $object)
    {
        try {
            $this->objectResourceModel->save($object);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $object = $this->objectFactory->create();
        $this->objectResourceModel->load($object, $id);
        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function delete(CustomCatalogInterface $object)
    {
        try {
            $this->objectResourceModel->delete($object);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }


    public function getbyvpn($vpn)
    {
        $collection = $this->collectionFactory->create()->addFieldToFilter('vpn',$vpn);

        return $collection->getData();
    }


    //Changed to Subscribe model for RAbbitMQ requirement

    public function setcustomcatalog($entity_id,$copy_writeinfo,$vpn)
    {
        $data = [
                    'entity_id' => $entity_id,
                    'copy_writeinfo' => $copy_writeinfo,
                    'vpn' => $vpn,
                ]; 

        if(empty($entity_id))
            return  "Entity Id Cant Be Blank, Please provide id";


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
