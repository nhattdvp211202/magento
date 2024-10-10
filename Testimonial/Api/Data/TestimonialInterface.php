<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Api\Data;

interface TestimonialInterface
{
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set Email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get Message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set Message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);

    /**
     * Get Company
     *
     * @return string|null
     */
    public function getCompany();

    /**
     * Set Company
     *
     * @param string $company
     * @return $this
     */
    public function setCompany($company);

    /**
     * Get Rating
     *
     * @return int|null
     */
    public function getRating();

    /**
     * Set Rating
     *
     * @param int $rating
     * @return $this
     */
    public function setRating($rating);

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set Image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Get Status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set Created At
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set Customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);
}
