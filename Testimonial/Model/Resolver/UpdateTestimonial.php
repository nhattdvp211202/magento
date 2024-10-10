<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Model\Resolver;

use Tigren\Testimonial\Model\ResourceModel\Testimonial as TestimonialResource;
use Tigren\Testimonial\Model\TestimonialFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class UpdateTestimonial implements ResolverInterface
{
    /**
     * @var TestimonialFactory
     */
    protected $testimonialFactory;
    /**
     * @var TestimonialResource
     */
    protected $testimonialResource;

    /**
     * @param TestimonialFactory $testimonialFactory
     * @param TestimonialResource $testimonialResource
     */
    public function __construct(
        TestimonialFactory $testimonialFactory,
        TestimonialResource $testimonialResource
    ) {
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialResource = $testimonialResource;
    }

    /**
     * @param Field $field
     * @param $context
     * @param $info
     * @param $value
     * @param $args
     * @return \Magento\Framework\GraphQl\Query\Resolver\Value|mixed|\Tigren\Testimonial\Model\Testimonial
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function resolve(
        Field $field,
              $context,
              $info,
              $value = null,
              $args = null
    ) {
        // Tải testimonial từ database
        $testimonial = $this->testimonialFactory->create();
        $this->testimonialResource->load($testimonial, $args['id']);

        if (!$testimonial->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Testimonial not found'));
        }

        // Cập nhật dữ liệu
        $testimonial->addData($args['input']);
        $this->testimonialResource->save($testimonial);
        return $testimonial;
    }
}
