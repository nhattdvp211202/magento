<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\SessionFactory;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use Psr\Log\LoggerInterface;

class ListTestimonials extends Template
{
    protected $testimonialCollectionFactory;
    protected $customerSessionFactory;
    protected $logger;

    public function __construct(
        Context           $context,
        CollectionFactory $testimonialCollectionFactory,
        SessionFactory $customerSessionFactory,
        LoggerInterface   $logger,
        array             $data = []
    )
    {

        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->customerSessionFactory = $customerSessionFactory;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    public function getCustomerId()
    {
        $customerSession = $this->customerSessionFactory->create();
        return $customerSession->getCustomer()->getId();
    }

    public function getTestimonials()
    {
        $customerId = $this->getCustomerId();
        if ($customerId) {
            $collection = $this->testimonialCollectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customerId); // Giả sử bạn có trường customer_id trong bảng
            return $collection;
        }

        return []; // Trả về mảng rỗng nếu không có customer ID
    }

    public function getCreateNewTestimonialUrl()
    {
        return $this->getUrl('testimonial/index/create');
    }
}
