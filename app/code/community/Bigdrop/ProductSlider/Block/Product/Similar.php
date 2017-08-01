<?php
/**
 * Custom Product Sliders
 * Similar products to the current
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Product_Similar extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'similar';

    /**
     * Retrieve values of properties that unambiguously identify unique content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            'PRODUCT_SLIDER_BLOCK',
            $this->_code,
            Mage::app()->getStore()->getCode() . $this->getProduct()->getId(),
        );
    }

    /**
     * Find needed Category of the current product
     *
     * @param $product
     * @return bool|Mage_Core_Model_Abstract
     */
    protected function _getCategory($product)
    {
        $categoryIds = $product->getCategoryIds();

        if (!empty($categoryIds)) {
            $categoryId = end($categoryIds);
            $category   = Mage::getModel('catalog/category')->load($categoryId);
            return $category;
        }

        return false;
    }

    /**
     * Exchange a standard collection to the category product collection
     *
     * @return array|Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _getCollection()
    {
        $product = $this->getProduct();

        if (!$product) {
            return array();
        }

        $category = $this->_getCategory($product);

        if (!$category) {
            return array();
        }

        return $category->getProductCollection();
    }

    /**
     * Preparing Similar products to the current product
     *
     * @param $collection
     */
    protected function _applyFilterToCollection($collection)
    {
        /** Avoid current product */
        $collection->addFieldToFilter('entity_id', array('nin'=>$this->getProduct()->getId()));
    }
}