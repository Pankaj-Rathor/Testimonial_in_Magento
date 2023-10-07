<?php
namespace Pankaj\Testimonial\Controller\Adminhtml\Testimonial;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;

class Deleteimage extends \Magento\Backend\App\Action
{
    const IMAGE_PATH = 'testimonial/image/';

    /**
     * @var File
     */
    protected $file;

    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Pankaj\Testimonial\Model\Testimonial $testimonial,
        Filesystem $filesystem,
        File $file
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->testimonial = $testimonial;
        $this->mediaDirectory = $filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $this->file = $file;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if (!empty($id)) {
            $model = $this->testimonial->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Testimonial no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $imageName = $model->getImage();
            $model->setData('image','');
            try {
               // Remove the image file
                echo $fullImage = $this->mediaDirectory->getAbsolutePath(self::IMAGE_PATH).$imageName;
                if ($this->file->isExists($fullImage)) {
                    $this->file->deleteFile($fullImage);
                }
                $model->save();
                $this->messageManager->addSuccessMessage(__('You removed the Testimonial Image.'));
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while remove the Testimonial Image.'));
            }        
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');        
    }
}

