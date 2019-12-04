<?php
namespace Altayer\CustomCatalog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
            

/**
 * Class Save
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Altayer_CustomCatalog::addnewproduct';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    protected $productFactory;
    protected $_storeManager;

    /**
     * @var \Altayer\CustomCatalog\Model\CustomCatalogRepository
     */
    protected $objectRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Altayer\CustomCatalog\Model\CustomCatalogRepository $objectRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Altayer\CustomCatalog\Model\CustomCatalogRepository $objectRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->dataPersistor    = $dataPersistor;
        $this->objectRepository  = $objectRepository;
        $this->productFactory =  $productFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Altayer\CustomCatalog\Model\CustomCatalog::STATUS_ENABLED;
            }
            if (empty($data['catalog_product_id'])) {
                $data['catalog_product_id'] = null;
            }

            /** @var \Altayer\CustomCatalog\Model\CustomCatalog $model */
            $model = $this->_objectManager->create('Altayer\CustomCatalog\Model\CustomCatalog');

            $id = $this->getRequest()->getParam('catalog_product_id');
            if ($id) {
                $model = $this->objectRepository->getById($id);
            }

            $model->setData($data);
            


            try {
                $this->objectRepository->save($model);
                // $this->messageManager->addSuccess(__('Custom Product Saved.'));
                $this->dataPersistor->clear('altayer_customcatalog_customcatalog');
                $product = $this->productFactory->create();
                $loadedProduct = $product->loadByAttribute('sku',$data['sku']);
                if($loadedProduct)
                {
                    $loadedProduct->setStoreId(0);
                    $loadedProduct->setVpn($data['vpn']);

                    $loadedProduct->setCopyWriteInfo($data['copy_write_info']);
                    $loadedProduct->save();
                }
                else
                {
                    $this->messageManager->addWarning(__('Product Saved. Catalog/Product not updated as the sku of the product doesnt exist in main catalog'));
                }
                 $this->messageManager->addSuccess(__('Product Saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->dataPersistor->set('altayer_customcatalog_customcatalog', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('catalog_product_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
