<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Controller\Adminhtml\Index;

use Tigren\Testimonial\Helper\ReindexHelper;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends Action
{
    protected $reindexHelper;

    public function __construct(
        Action\Context $context,
        ReindexHelper  $reindexHelper
    )
    {
        $this->reindexHelper = $reindexHelper;
        parent::__construct($context);
    }

    const ADMIN_RESOURCE = 'Tigren_Testimonial::delete';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Tigren\Testimonial\Model\Testimonial');
                $model->load($id);

                if (!$model->getId()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('This testimonial no longer exists.'));
                }

                $model->delete();
                $this->reindexHelper->reindexIds();

                $this->messageManager->addSuccessMessage(__('The testimonial has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a testimonial to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
