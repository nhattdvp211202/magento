<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\Testimonial\Api\Data\TestimonialInterface;

class Testimonial extends AbstractModel implements TestimonialInterface
{
    /**
     * Testimonial's Statuses
     */
    const STATUS_ENABLED = 1;
    /**
     *
     */
    const STATUS_DISABLED = 0;



    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\Testimonial\Model\ResourceModel\Testimonial');
    }

    /**
     * Prepare testimonial's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }

    /**
     * Get Message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData('message');
    }

    /**
     * Set Message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        return $this->setData('message', $message);
    }

    /**
     * Get Company
     *
     * @return string|null
     */
    public function getCompany()
    {
        return $this->getData('company');
    }

    /**
     * Set Company
     *
     * @param string $company
     * @return $this
     */
    public function setCompany($company)
    {
        return $this->setData('company', $company);
    }

    /**
     * Get Rating
     *
     * @return int|null
     */
    public function getRating()
    {
        return $this->getData('rating');
    }

    /**
     * Set Rating
     *
     * @param int $rating
     * @return $this
     */
    public function setRating($rating)
    {
        return $this->setData('rating', $rating);
    }

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData('image');
    }

    /**
     * Set Image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData('image', $image);
    }

    /**
     * Get Status
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->getData('status');
    }

    /**
     * Set Status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * Set Created At
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData('created_at', $createdAt);
    }

    /**
     * Get Rating
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * Set Customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }
}
