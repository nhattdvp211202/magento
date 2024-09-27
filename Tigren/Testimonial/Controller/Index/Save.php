<?php

namespace Tigren\Testimonial\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Tigren\Testimonial\Model\TestimonialFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends Action
{
    protected $testimonialFactory;
    protected $uploaderFactory;
    protected $filesystem;

    public function __construct(
        Context $context,
        TestimonialFactory $testimonialFactory,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem
    ) {
        $this->testimonialFactory = $testimonialFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('*/*/');
        }

        try {
            $testimonial = $this->testimonialFactory->create();
            $testimonial->setData($data);

            // Xử lý upload hình ảnh
            if (!empty($_FILES['image']['name'])) {
                $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('testimonial/image/');
                $result = $uploader->save($mediaPath);
                $testimonial->setImage($result['file']);
            }

            $testimonial->save();
            $this->messageManager->addSuccessMessage(__('Your testimonial has been submitted.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while saving testimonial.'));
        }

        return $this->_redirect('*/*/listtestimonials');
    }
}
