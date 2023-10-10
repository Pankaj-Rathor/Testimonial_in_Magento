<?php
namespace Pankaj\Testimonial\ViewModel;

use Magento\Framework\UrlInterface;

class TestimonialView implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    protected $urlInterface;

    public function __construct(
        UrlInterface $urlInterface
    )
    {
        $this->urlInterface = $urlInterface;
    }

    public function getImageUrl($image)
    {
        if (!empty($image)) {
            return $this->urlInterface->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).'testimonial/image/'.$image;            
        }
        //Default Image
        return $this->urlInterface->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).'testimonial/image/'.$image;
    }
}
