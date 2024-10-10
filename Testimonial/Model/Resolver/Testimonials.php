<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Model\Resolver;

use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory as TestimonialCollectionFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class Testimonials implements ResolverInterface
{
    /**
     * @var TestimonialCollectionFactory
     */
    protected $testimonialCollectionFactory;

    /**
     * @param TestimonialCollectionFactory $testimonialCollectionFactory
     */
    public function __construct(TestimonialCollectionFactory $testimonialCollectionFactory)
    {
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
    }

    /**
     * @param Field $field
     * @param $context
     * @param $info
     * @param $value
     * @param $args
     * @return \Magento\Framework\DataObject[]|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     */
    public function resolve(
        Field $field,
              $context,
              $info,
              $value = null,
              $args = null
    ) {
        // Sử dụng CollectionFactory để lấy danh sách testimonials
        return $this->testimonialCollectionFactory->create()->getItems();
    }
}
