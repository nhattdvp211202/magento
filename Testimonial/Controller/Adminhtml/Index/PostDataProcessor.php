<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Index;

class PostDataProcessor
{

    protected $messageManager;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    // Validate required columns
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'name' => __('Name'),
            'email' => __('Email'),
            'message' => __('Message'),
            'company' => __('Company'),
            'rating' => __('Rating'),
            'image' => __('Image'),
            'status' => __('Status'),
            'created_at' => __('Create At')
        ];
        $errorNo = true;
        return $errorNo;
    }
}
