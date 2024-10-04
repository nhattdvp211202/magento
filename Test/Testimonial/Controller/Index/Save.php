<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Tigren\Testimonial\Model\TestimonialFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Customer\Model\Session;

// Thêm lớp Customer Session

class Save extends Action
{
    /**
     * @var TestimonialFactory
     */
    protected $testimonialFactory;
    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;
    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param TestimonialFactory $testimonialFactory
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param Session $customerSession
     */
    public function __construct(
        Context            $context,
        TestimonialFactory $testimonialFactory,
        UploaderFactory    $uploaderFactory,
        Filesystem         $filesystem,
        Session            $customerSession
    )
    {
        $this->testimonialFactory = $testimonialFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('*/*/');
        }

        try {
            $testimonial = $this->testimonialFactory->create();
            $testimonial->setData($data);

            // Lấy customer_id
            if ($this->customerSession->isLoggedIn()) {
                $customerId = $this->customerSession->getCustomerId();
                $testimonial->setCustomerId($customerId);
            }

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
