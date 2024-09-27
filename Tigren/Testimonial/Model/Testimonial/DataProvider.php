<?php

namespace Tigren\Testimonial\Model\Testimonial;

use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $testimonialCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $testimonialCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     */
    public function getData()
    {
        // Get items
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $testimonial) {
            $data = $testimonial->getData();
            $image = isset($data['image']) ? $data['image'] : '';

            if ($image && is_string($image)) {
                // Đảm bảo rằng $data['image'] là một mảng
                $data['image'] = [
                    [
                        'name' => $image,
                        'url' => $this->storeManager->getStore()
                            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                            . 'testimonial/image/' . $image
                    ]
                ];
            }

            $this->loadedData[$testimonial->getId()] = $data;
        }

        $data = $this->dataPersistor->get('testimonial');
        if (!empty($data)) {
            $testimonial = $this->collection->getNewEmptyItem();
            $testimonial->setData($data);
            $this->loadedData[$testimonial->getId()] = $testimonial->getData();
            $this->dataPersistor->clear('testimonial');
        }

        return $this->loadedData;
    }
}
