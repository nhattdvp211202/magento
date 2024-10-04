<?php

namespace Tigren\Testimonial\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session as CustomerSession;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use Psr\Log\LoggerInterface;

class ListTestimonials extends Template
{
    protected $testimonialCollectionFactory;
    protected $customerSession;
    protected $logger; // Thêm thuộc tính logger

    public function __construct(
        Context           $context,
        CollectionFactory $testimonialCollectionFactory,
        CustomerSession   $customerSession,
        LoggerInterface   $logger, // Thêm dependency injection cho logger
        array             $data = []
    )
    {
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->customerSession = $customerSession;
        $this->logger = $logger; // Khởi tạo logger
        parent::__construct($context, $data);
    }

    public function getTestimonials()
    {
        try {
//            $customerId = $this->getCustomerId();
            $collection = $this->testimonialCollectionFactory->create();
//            $collection->addFieldToFilter('customer_id', $customerId);
            return $collection->getItems();
        } catch (\Exception $e) {
            $this->logger->error('Error fetching testimonials: ' . $e->getMessage());
            return [];
        }
    }

    public function getCreateNewTestimonialUrl()
    {
        return $this->getUrl('testimonial/index/create');
    }
}
