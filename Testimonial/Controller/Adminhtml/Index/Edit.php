<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Tigren_Testimonial::save';

    protected $_coreRegistry;
    protected $resultPageFactory;

    public function __construct(
        Action\Context                             $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry                $registry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Load layout and set active menu
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Tigren_Testimonial::testimonial');
        return $resultPage;
    }

    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Tigren\Testimonial\Model\Testimonial');

        // Initial checking
        if ($id) {
            $model->load($id);

            // If cannot get ID of model, display error message and redirect to List page
            if (!$model->getId()) {
                $this->messageManager->addError(__('This question no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // Registry testimonial
        $this->_coreRegistry->register('testimonial', $model);

        // Build form
        $resultPage = $this->_initAction();
        if ($id) {
            $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getImage() : __('Edit Question'));
        } else {
            $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getImage() : __('Create Question'));
        }


        return $resultPage;
    }
}
