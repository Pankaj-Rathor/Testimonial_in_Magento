<?php
namespace Pankaj\Testimonial\ViewModel;

use Magento\Framework\UrlInterface;

class TestimonialView implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    protected $urlInterface;
    protected $assetRepo;

    public function __construct(
        UrlInterface $urlInterface,
        \Magento\Framework\View\Asset\Repository $assetRepo
    )
    {
        $this->urlInterface = $urlInterface;
        $this->_assetRepo = $assetRepo;
    }

    public function getImageUrl($image)
    {
        if (!empty($image))
        {
            return $this->urlInterface->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).'testimonial/image/'.$image;
        }
        return $this->getPlaceholderImage();
    }

    public function getPlaceholderImage()
    {
       return $this->_assetRepo->getUrl("Pankaj_Testimonial::images/default_user.png");
    }
}
