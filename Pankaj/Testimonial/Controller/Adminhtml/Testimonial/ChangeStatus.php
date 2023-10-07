<?php
namespace Pankaj\Testimonial\Controller\Adminhtml\Testimonial;

class ChangeStatus extends \Pankaj\Testimonial\Controller\Adminhtml\Testimonial
{
    public function __construct(
        protected \Magento\Backend\App\Action\Context $context,
        protected \Magento\Framework\Registry $coreRegistry,
        protected \Pankaj\Testimonial\Model\Config $config,
        protected \Pankaj\Testimonial\Model\Testimonial $testimonial
    ) {
        $this->testimonial = $testimonial;
        parent::__construct($context, $coreRegistry, $config);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->testimonial->load($id);
                
                $model->setData('status',$this->updatedStatus($model))->save();
                // display success message
                $this->messageManager->addSuccessMessage(__('You update the status of the testimonial.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Testimonial to update the status.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }

    public function updatedStatus($testimonial)
    {
        return ($testimonial->getStatus() == 1)? 0 : 1;
    }
}
