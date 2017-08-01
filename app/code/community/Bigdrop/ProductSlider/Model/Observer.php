<?php
/**
 * Custom Product Sliders
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Model_Observer
{
    /**
     * @var Bigdrop_ProductSlider_Helper_Data
     */
    protected $_helper;

    /**
     * Bigdrop_ProductSlider_Model_Observer constructor.
     */
    public function __construct()
    {
        $this->_helper = Mage::helper('bd_product_slider');
    }

    /**
     * Adding sliders on the product view page
     *
     * @event 'controller_action_layout_render_before_catalog_product_view'
     */
    public function addProductSlidersOnProductViewPage()
    {
        /** @var Mage_Core_Model_Layout $layout */
        $layout = Mage::app()->getLayout();

        /* Append Similar products slider to the layout */
        if ($this->_helper->getSliderConfig('similar')->getIsEnabled()) {
            $similarSliderBlock = $layout->createBlock('bd_product_slider/product_similar', 'similar.products.slider');
            $layout->getBlock('product.info.additional')
                ->append($similarSliderBlock, 'similar_products_slider');
        }

        /* Append Associated products slider to the layout */
        if ($this->_helper->getSliderConfig('associated')->getIsEnabled()) {
            $associatedSliderBlock = $layout->createBlock('bd_product_slider/product_associated', 'associated.products.slider');
            $layout->getBlock('product.info.additional')
                ->append($associatedSliderBlock, 'associated_products_slider');
        }
    }

    /**
     * Adding sliders on the shopping cart page
     *
     * @param Varien_Event_Observer $observer
     * @event 'core_block_abstract_to_html_after'
     */
    public function addProductSlidersOnShoppingCartPage(Varien_Event_Observer $observer)
    {
        /* Check the block name */
        if ($observer->getBlock()->getNameInLayout() != 'checkout.cart') {
            return;
        }

        /** @var Mage_Core_Model_Layout $layout */
        $layout = Mage::app()->getLayout();

        /* Insert Similar products slider's html to the block */
        if ($this->_helper->getSliderConfig('cart_similar')->getIsEnabled()) {
            $cartSimilarSliderBlock = $layout->createBlock('bd_product_slider/checkout_cart_similar');
            $html = $observer->getTransport()->getHtml() . $cartSimilarSliderBlock->toHtml();
            $observer->getTransport()->setHtml($html);
        }
    }

    /**
     * Adding sliders on the customer's wishlist page
     *
     * @event 'controller_action_layout_render_before_wishlist_index_index'
     */
    public function addProductSlidersOnCustomerWishlistPage()
    {
        /** @var Mage_Core_Model_Layout $layout */
        $layout = Mage::app()->getLayout();

        /* Append Similar products slider to the layout */
        if ($this->_helper->getSliderConfig('wishlist_similar')->getIsEnabled()) {
            $wishlistSimilarSliderBlock = $layout->createBlock('bd_product_slider/wishlist_similar', 'wishlist.similar.products.slider');
            $layout->getBlock('my.account.wrapper')
                ->append($wishlistSimilarSliderBlock, 'wishlist_similar_products_slider');
        }
    }
}