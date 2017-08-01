<?php
/**
 * Custom Product Sliders
 * Bestsellers
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Bestsellers extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'bestsellers';

    /**
     * Retrieves sort by param
     *
     * @return string
     */
    protected function _getSortByParam()
    {
        return 'ordered_qty';
    }

    /**
     * Preparing product collection of the current Slider
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection|Mage_Reports_Model_Resource_Product_Collection
     */
    protected function _prepareSliderCollection()
    {
        $collection = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty();

        if (Mage::helper('catalog/product_flat')->isEnabled()) {
            $collection->getSelect()
                ->joinInner(array(
                    'e2' => 'catalog_product_flat_' . Mage::app()->getStore()->getId()
                ), 'e2.entity_id = e.entity_id');
        } else {
            $this->assignAttributes($collection);
        }

        $this->_applyStockVisibilityFilter($collection);
        $this->_setOrderToCollection($collection);
        $collection->getSelect()->limit($this->_getLimit());

        return $collection;
    }
}