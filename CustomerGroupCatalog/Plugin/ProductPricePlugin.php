<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;

class ProductPricePlugin
{
    /**
     * @var HttpContext
     */
    protected $httpContext;

    /**
     * @param HttpContext $httpContext
     */
    public function __construct(HttpContext $httpContext)
    {
        $this->httpContext = $httpContext;
    }

    /**
     * Hide price for non-logged-in customers
     *
     * @param FinalPriceBox $subject
     * @param string $result
     * @return string
     */
    public function afterToHtml(FinalPriceBox $subject, $result)
    {
        if (!$this->httpContext->getValue(CustomerContext::CONTEXT_AUTH)) {
            return '';
        }

        return $result;
    }
}
