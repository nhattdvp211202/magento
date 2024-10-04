<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Model\Testimonial;

use Tigren\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var \Tigren\Testimonial\Model\ResourceModel\Testimonial\Collection
     */
    protected $collection;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var
     */
    protected $loadedData;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $testimonialCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string                                     $name, // Khai báo kiểu string cho $name
        string                                     $primaryFieldName, // Khai báo kiểu string cho $primaryFieldName
        string                                     $requestFieldName, // Khai báo kiểu string cho $requestFieldName
        CollectionFactory                          $testimonialCollectionFactory,
        DataPersistorInterface                     $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array                                      $meta = [],
        array                                      $data = []
    )
    {
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
