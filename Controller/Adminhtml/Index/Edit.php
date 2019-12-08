<?php
namespace Altayer\CustomCatalog\Controller\Adminhtml\Index;


/**
 * Class Edit
 */
class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Altayer_CustomCatalog::addnewproduct';
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
        $resultPage  = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Products')));
        return $resultPage;
    }
}
