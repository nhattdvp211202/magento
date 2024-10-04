<?php
namespace Tigren\Testimonial\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\CategoryRepository;

class CategoryRedirect implements ObserverInterface
{
    protected $redirect;
    protected $request;
    protected $categoryRepository;

    public function __construct(
        RedirectInterface $redirect,
        RequestInterface $request,
        CategoryRepository $categoryRepository
    ) {
        $this->redirect = $redirect;
        $this->request = $request;
        $this->categoryRepository = $categoryRepository;
    }

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
