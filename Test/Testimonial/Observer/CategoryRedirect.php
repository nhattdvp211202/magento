<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Testimonial\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\CategoryRepository;

class CategoryRedirect implements ObserverInterface
{
    /**
     * @var RedirectInterface
     */
    protected $redirect;
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @param RedirectInterface $redirect
     * @param RequestInterface $request
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        RedirectInterface  $redirect,
        RequestInterface   $request,
        CategoryRepository $categoryRepository
    )
    {
        $this->redirect = $redirect;
        $this->request = $request;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        // Lấy ID của category từ request
        $categoryId = $this->request->getParam('id');
        if ($categoryId) {
            // Load category để kiểm tra
            $category = $this->categoryRepository->get($categoryId);
            if ($category && $category->getName() === 'Testimonial') {
                // Chuyển hướng đến trang testimonial
                $observer->getControllerAction()->getResponse()->setRedirect('/testimonial/index/listtestimonials');
            }
        }
    }
}
