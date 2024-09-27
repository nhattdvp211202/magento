<?php

namespace Tigren\Testimonial\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{

    protected $context;
    protected $testimonialFactory;

    public function __construct(
        Context $context,
        \Tigren\Testimonial\Model\TestimonialFactory $testimonialFactory
    ) {
        $this->context = $context;
        $this->testimonialFactory = $testimonialFactory;
    }

    /**
     * Return Testimonial ID
     */
    public function getTestimonialId()
    {
        $id = $this->context->getRequest()->getParam('id');
        $testimonial = $this->testimonialFactory->create()->load($id);
        if ($testimonial->getId())
            return $id;
        return null;
    }

    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
