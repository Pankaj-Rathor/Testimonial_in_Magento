<?php
namespace Pankaj\Testimonial\Controller\Adminhtml\Testimonial;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Pankaj_Testimonial::testimonial_list';

    const PAGE_TITLE = 'Testimonials';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;
    protected $config;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       \Pankaj\Testimonial\Model\Config $config
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->config = $config;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
         /** @var \Magento\Framework\View\Result\Page $resultPage */
         $resultPage = $this->_pageFactory->create();
         $resultPage->setActiveMenu(static::ADMIN_RESOURCE);
         $resultPage->addBreadcrumb(__(static::PAGE_TITLE), __(static::PAGE_TITLE));
         $resultPage->getConfig()->getTitle()->prepend(__(static::PAGE_TITLE));

         return $resultPage;
    }

    /**
     * Is the user allowed to view the page.
    *
    * @return bool
    */
    protected function _isAllowed()
    {
        return ($this->_authorization->isAllowed(static::ADMIN_RESOURCE) && $this->config->isEnable());
    }
}
