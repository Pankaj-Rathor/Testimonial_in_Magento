<?php
namespace Pankaj\Testimonial\Block;

class TestimonialList extends \Magento\Framework\View\Element\Template
{
    protected $request;
    protected $testimonialFactory;
    protected $customerRepository;
    protected $config;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\RequestInterface $request,
        \Pankaj\Testimonial\Model\TestimonialFactory $testimonialFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Pankaj\Testimonial\Model\Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->testimonialFactory = $testimonialFactory;
        $this->customerRepository = $customerRepository;
        $this->config = $config;
        $pageTitle = ($this->config->getPageTitle()) ? $this->config->getPageTitle() : 'Testimonial';
        $this->setName($pageTitle);
    }

    public function getTestimonialCollection()
    {
        $limit = ($this->request->getParam('limit')) ? $this->request->getParam('limit'):5;
        $page = ($this->request->getParam('p')) ? $this->request->getParam('p'):1;

        return $this->testimonialFactory->create()
            ->getCollection()
            // ->addFieldToSelect('*')
            ->addFieldToFilter('status',1)
            ->setOrder('publish_date','DESC')
            ->setPageSize($limit)
            ->setCurPage($page);
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();
        
        if ($testimonialCollection = $this->getTestimonialCollection()) 
        {
            $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager','testimonial.pager')
            ->setAvailableLimit([5=>5,10=>10,15=>15,20=>20])
            ->setShowPerPager(true)
            ->setCollection($testimonialCollection);

            $this->setChild('pager',$pager);
        }
       
        return $this;
    }

    public function getCustomerName(int $customerId)
    {
        try{
            $customer = $this->customerRepository->getById($customerId);
        
            if ($customer->getId()) {
                return $customer->getFirstname() .' '. $customer->getLastname();
            }
        
        } catch (Exception $e) {
            // echo $e->getMessage();
            return $customerId;
        }
    }

}
