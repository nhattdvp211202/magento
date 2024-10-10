<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Model;

use Tigren\Testimonial\Api\TestimonialRepositoryInterface;
use Tigren\Testimonial\Api\Data\TestimonialInterfaceFactory;
use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use Tigren\Testimonial\Model\ResourceModel\Testimonial as TestimonialResource;
use Tigren\Testimonial\Api\Data\TestimonialInterface;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    /**
     * @var TestimonialInterfaceFactory
     */
    protected $testimonialFactory;
    /**
     * @var CollectionFactory
     */
    protected $testimonialCollectionFactory;
    /**
     * @var TestimonialResource
     */
    protected $testimonialResource;

    /**
     * @param TestimonialInterfaceFactory $testimonialFactory
     * @param CollectionFactory $testimonialCollectionFactory
     * @param TestimonialResource $testimonialResource
     */
    public function __construct(
        TestimonialInterfaceFactory $testimonialFactory,
        CollectionFactory $testimonialCollectionFactory,
        TestimonialResource $testimonialResource
    ) {
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->testimonialResource = $testimonialResource;
    }

    /**
     * @return array|TestimonialInterface[]
     */
    public function getList()
    {
        $collection = $this->testimonialCollectionFactory->create();
        $testimonials = [];

        foreach ($collection as $testimonial) {
            $testimonials[] = $testimonial->getData();
        }

        return $testimonials;
    }

    /**
     * @param TestimonialInterface $testimonial
     * @return TestimonialInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(TestimonialInterface $testimonial)
    {
        $this->testimonialResource->save($testimonial);
        return $testimonial;
    }

    /**
     * @param $id
     * @return true
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $testimonial = $this->getById($id);
        $this->testimonialResource->delete($testimonial);
        return true;
    }
}
