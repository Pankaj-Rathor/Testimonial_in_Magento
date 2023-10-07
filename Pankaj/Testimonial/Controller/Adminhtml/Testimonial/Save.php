<?php
namespace Pankaj\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @var \Pankaj\Testimonial\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Pankaj\Testimonial\Model\ImageUploader $imageUploader,
        \Pankaj\Testimonial\Model\Testimonial $testimonial
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        $this->testimonial = $testimonial;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        // echo "<pre>";print_r($data);exit;
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');
        
            $model = $this->testimonial->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Testimonial no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            //upload image  
            if (isset($data['image'])) {
                $data = $this->imageSaveToDir($data);
                $data['image'] = $data['image'];   
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $model->setData($data);
        
            try {
                if (isset($data['image'])) {
                    /**  \Pankaj\Testimonial\Model\ImageUploader $imageUploader */
                    $this->imageUploader->moveFileFromTmp($data['image']);
                }

                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Testimonial.'));
                $this->dataPersistor->clear('pankaj_testimonial_testimonial');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Testimonial.'));
            }
        
            $this->dataPersistor->set('pankaj_testimonial_testimonial', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function imageSaveToDir(array $rawData) {
        $data = $rawData;
        if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['name'];
        } elseif (isset($data['image'][0]['image']) && !isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['image'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }
}

