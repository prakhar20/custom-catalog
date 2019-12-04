<?php
namespace Altayer\CustomCatalog\Controller\Adminhtml\Index;
class Index extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Altayer_CustomCatalog::custom_catalog_menu';

    protected $resultPageFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Products')));
        return $resultPage;
    }
    protected function _isAllowed()
    {
        // return false;
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
