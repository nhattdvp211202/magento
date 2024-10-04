<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{

    protected $context;
    protected $testimonialFactory;

    public function __construct(
        Context                                      $context,
        \Tigren\Testimonial\Model\TestimonialFactory $testimonialFactory
    )
    {
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
