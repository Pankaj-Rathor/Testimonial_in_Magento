<?php

namespace Pankaj\Testimonial\Controller\Adminhtml\Testimonial;

class Delete extends \Pankaj\Testimonial\Controller\Adminhtml\Testimonial
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Pankaj\Testimonial\Model\Config $config,
        \Pankaj\Testimonial\Model\Testimonial $testimonial
    ) {
        $this->testimonial = $testimonial;
        parent::__construct($context, $coreRegistry, $config);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
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
                $this->testimonial->load($id)->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Testimonial.'));
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
        $this->messageManager->addErrorMessage(__('We can\'t find a Testimonial to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
