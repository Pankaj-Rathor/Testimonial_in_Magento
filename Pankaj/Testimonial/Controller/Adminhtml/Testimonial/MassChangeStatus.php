<?php
namespace Pankaj\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Pankaj\Testimonial\Model\TestimonialFactory;
use Pankaj\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;

class MassChangeStatus extends Action
{
    protected $filter;
    protected $resultPageFactory;
    protected $collectionFactory;
    protected $testimonialFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Filter $filter,
        TestimonialFactory $testimonialFactory,
        CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->filter = $filter;
        $this->testimonialFactory = $testimonialFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $updated = 0;
            foreach ($collection as $item) {
                $model = $this->testimonialFactory->create()->load($item['entity_id']);
                $model->setData('status', $this->getRequest()->getParam('status'));
                $model->save();
                $updated++;
            }
            if ($updated) {
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were updated.', $updated));
            }

        } catch (\Exception $e) {
            // \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($e->getMessage());
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

}