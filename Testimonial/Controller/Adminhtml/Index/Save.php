<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Tigren\Testimonial\Model\Testimonial;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Tigren_Testimonial::save';

    protected $dataProcessor;
    protected $dataPersistor;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            // Optimize data
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Testimonial::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            if (empty($data['image'])) {
                $data['image'] = null;
            } else {
                if (isset($data['image'][0]) && isset($data['image'][0]['name']) && $data['image'][0]['name']) {
                    $data['image'] = $data['image'][0]['name'];
                } else {
                    $data['image'] = null;
                }
            }

            // Init model and load by ID if exists
            $model = $this->_objectManager->create('Tigren\Testimonial\Model\Testimonial');
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }

            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the testimonial.'));
                $this->dataPersistor->clear('testimonial');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the testimonial.'));
            }

            $this->dataPersistor->set('testimonial', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}
