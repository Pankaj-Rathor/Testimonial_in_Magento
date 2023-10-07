<?php
namespace Pankaj\Testimonial\Model;

use Magento\Store\Model\ScopeInterface;

class Config
{
    const ENABLE = 'testimonial/general/enable';
    const PAGE_TITLE = 'testimonial/general/page_title';

    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnable()
    {
        return $this->scopeConfig->getValue(self::ENABLE, ScopeInterface::SCOPE_STORE);
    }

    public function getPageTitle()
    {
        return $this->scopeConfig->getValue(self::PAGE_TITLE, ScopeInterface::SCOPE_STORE);
    }
}
