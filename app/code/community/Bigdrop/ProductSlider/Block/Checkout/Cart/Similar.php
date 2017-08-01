<?php
/**
 * Custom Product Sliders
 * Similar products to the current products on the Cart page
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Checkout_Cart_Similar extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'cart_similar';

    /**
     * @var array
     */
    protected $_entityIds;

    /**
     * Disable block caching
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setCacheLifetime(null);
    }

    /**
     * @return Mage_Sales_Model_Quote
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart')->getQuote();
    }

    /**
     * Find needed Category Ids of the current products in the cart and setting them ids
     *
     * @return Varien_Object
     */
    protected function _getEntityIds()
    {
        if (empty($this->_entityIds)) {
            $categoryIds = array();
            $productIds  = array();

            foreach ($this->_getCart()->getAllVisibleItems() as $item) {
                $product  = $item->getProduct();
                $category = $product->getCategory();
                $productIds[] = $product->getId();

                if (!$category) {
                    $catIds = $product->getCategoryIds();

                    if (!empty($catIds)) {
                        $categoryIds[] = array('finset' => end($catIds));
                    }
                }
            }

            $entityIds = array(
                'products'   => $productIds,
                'categories' => $categoryIds
            );

            $this->_entityIds = new Varien_Object($entityIds);
        }

        return $this->_entityIds;
    }

    /**
     * Exchange a standard collection to the category product collection
     *
     * @return array|Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _getCollection()
    {
        if (!$this->_getCart()->hasItems()) {
            return array();
        }

        if (!$this->_getEntityIds()->getCategories()) {
            return array();
        }

        return parent::_getCollection();
    }

    /**
     * Preparing Similar products to the current products in the cart
     *
     * @param $collection
     */
    protected function _applyFilterToCollection($collection)
    {
        $entityIds = $this->_getEntityIds();
        $collection->joinField(
            'category_id', 'catalog/category_product', 'category_id',
            'product_id = entity_id', null, 'left'
        )
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('category_id', $entityIds->getCategories());
        /** Avoid current product */
        $collection->addFieldToFilter('entity_id', array('nin'=>$entityIds->getProducts()));
    }
}