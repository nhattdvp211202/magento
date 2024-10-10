<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Api;

use Tigren\Testimonial\Api\Data\TestimonialInterface;

interface TestimonialRepositoryInterface
{
    /**
     * Get a list of testimonials.
     *
     * @return TestimonialInterface[]
     */
    public function getList();

    /**
     * Save a testimonial.
     *
     * @param TestimonialInterface $testimonial
     * @return TestimonialInterface
     */
    public function save(TestimonialInterface $testimonial);

    /**
     * Delete a testimonial by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

}
