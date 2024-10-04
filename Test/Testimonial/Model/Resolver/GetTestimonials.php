<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\GraphQl\Model\Query\ContextInterface;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;

class GetTestimonials implements ResolverInterface
{
    /**
     * @var CollectionFactory
     */
    protected $testimonialCollectionFactory;

    /**
     * @param CollectionFactory $testimonialCollectionFactory
     */
    public function __construct(
        CollectionFactory $testimonialCollectionFactory
    )
    {
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function resolve(
        Field       $field,
                    $context,
        ResolveInfo $info,
        array       $value = null,
        array       $args = null
    )
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        /** @var ContextInterface $context */
        if (!$context->getUserId()) {
            throw new \Magento\Framework\Exception\LocalizedException(__('You need to be logged in to see testimonials.'));
        }

        // Lấy danh sách testimonials từ collection
        $collection = $this->testimonialCollectionFactory->create();
        $collection->addFieldToSelect('*');

        $result = [];
        foreach ($collection as $testimonial) {
            $result[] = [
                'id' => $testimonial->getId(),
                'name' => $testimonial->getName(),
                'email' => $testimonial->getEmail(),
                'message' => $testimonial->getMessage(),
                'company' => $testimonial->getCompany(),
                'rating' => $testimonial->getRating(),
                'image' => $testimonial->getImage(),
                'status' => $testimonial->getStatus(),
                'created_at' => $testimonial->getCreatedAt(),
            ];
        }

        return $result;
    }
}
