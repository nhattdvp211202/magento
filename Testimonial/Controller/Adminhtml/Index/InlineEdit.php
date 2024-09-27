<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Tigren\Testimonial\Model\TestimonialFactory;

class InlineEdit extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Tigren_Testimonial::save';

    protected $testimonialFactory;
    protected $jsonFactory;

    public function __construct(
        Context $context,
        TestimonialFactory $testimonialFactory,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->testimonialFactory = $testimonialFactory;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        // Init result Json
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        // Get POST data
        $postItems = $this->getRequest()->getParam('items', []);

        // Check request
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        // Save data to database
        foreach (array_keys($postItems) as $testimonialId) {
            try {
                $testimonial = $this->testimonialFactory->create();
                $testimonial->load($testimonialId);
                $testimonial->setData($postItems[(string)$testimonialId]);
                $testimonial->save();
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong while saving the image.');
                $error = true;
            }
        }

        // Return result Json
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
