<?php
namespace Altayer\CustomCatalog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Altayer\CustomCatalog\Model\ResourceModel\CustomCatalog\CollectionFactory;
class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $productRepository;
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory,\Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
    {
        $this->filter = $filter;
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $record) {

            try{
                $product = $this->productRepository->get($record->getSku());
                $product->setCopywriteinfo(NULL);
                $product->setVpn(NULL);
                $product->save();

            }
            catch(\Magento\Framework\Exception\NoSuchEntityException $e)
            {
                 $this->messageManager->addWarning(__('The SKU %1 does not exist in main catalog, this will delete the record from custom products and will not update the main catalog',$record->getSku()));
            }
            $record->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 product(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
