<?php
/**
 * Custom Product Sliders
 * Similar products to the current products at the Wishlist
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Wishlist_Similar extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'wishlist_similar';

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
     * @return Mage_Wishlist_Model_Wishlist
     */
    protected function _getWishlist()
    {
        return $this->helper('wishlist')->getWishlist();
    }

    /**
     * Find needed Category Ids of the current products in the Wishlist and setting them ids
     *
     * @param Mage_Wishlist_Model_Wishlist $wishlist
     * @return Varien_Object
     */
    protected function _getEntityIds($wishlist)
    {
        if (empty($this->_entityIds)) {
            $categoryIds = array();
            $productIds  = array();

            foreach ($wishlist->getItemCollection() as $item) {
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
        if (!$this->_getWishlist()->getItemsCount()) {
            return array();
        }

        return parent::_getCollection();
    }

    /**
     * Preparing Similar products to the current products in the Wishlist
     *
     * @param $collection
     */
    protected function _applyFilterToCollection($collection)
    {
        $entityIds = $this->_getEntityIds($this->_getWishlist());

        $collection->joinField(
            'category_id', 'catalog/category_product', 'category_id',
            'product_id = entity_id', null, 'left'
        );

        if (Mage::helper('catalog/product_flat')->isEnabled()) {
            $collection->addAttributeToFilter(array(
                'category_id' => array(
                    'attribute' => 'category_id',
                    $entityIds->getCategories()
                )));
        } else {
            $collection->addAttributeToFilter('category_id', $entityIds->getCategories());
        }

        /** Avoid current product */
        $collection->addFieldToFilter('entity_id', array('nin'=>$entityIds->getProducts()));
    }
}