<?php
namespace Pankaj\Testimonial\Controller\Adminhtml;

abstract class Testimonial extends \Magento\Backend\App\Action
{

    protected $_coreRegistry;
    protected $config;
    const ADMIN_RESOURCE = 'Pankaj_Testimonial::testimonial';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Pankaj\Testimonial\Model\Config $config
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->config = $config;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE);
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

