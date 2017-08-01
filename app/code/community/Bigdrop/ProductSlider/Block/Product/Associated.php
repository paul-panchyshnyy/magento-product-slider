<?php
/**
 * Custom Product Sliders
 * Products that associated to the current
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Product_Associated extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'associated';

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

    /** @var array|null Attributes for filtering collection */
    protected $_attributes = array();

    /**
     * Setting data
     */
    protected function _construct()
    {
        parent::_construct();
        if ($attributes = $this->_getHelper()->getSliderConfig($this->_code)->getAssociatedAttributes()) {
            $this->_attributes = explode(',', $attributes);
        }
    }

    /**
     * Retrieves Main helper object
     *
     * @return Bigdrop_ProductSlider_Helper_Data
     */
    protected function _getHelper()
    {
        return $this->helper('bd_product_slider');
    }

    /**
     * Checks is product has attribute values and set it to the block
     *
     * @param $product
     * @return $this
     */
    protected function _prepareFilterableAttributes($product)
    {
        $isShowSlider = false;
        $filterByAttr = array();
        /** @var Bigdrop_ProductSlider_Helper_Data $helper */
        $helper = $this->_getHelper();

        if (!empty($this->_attributes)) {
            foreach ($this->_attributes as $attribute) {
                if ($value = $helper->getProductAttribute($product, $attribute, false)) {
                    $isShowSlider = true;
                    $filterByAttr[$attribute] = $value;
                }
            }
        }

        $this->setIsShowSlider($isShowSlider);
        $this->setFilterableAttributes($filterByAttr);

        return $this;
    }

    /**
     * Preparing Similar products to the current product
     */
    protected function _prepareSliderCollection()
    {
        $product = $this->getProduct();

        if (!$product) {
            return array();
        }

        $this->_prepareFilterableAttributes($product);

        if (!$this->getIsShowSlider()) {
            return array();
        }

        return parent::_prepareSliderCollection();
    }

    /**
     * Add filter to collection
     *
     * @param $collection
     */
    protected function _applyFilterToCollection($collection)
    {
        $attributes = $this->getFilterableAttributes();

        foreach ($attributes as $code => $value) {
            $collection->addFieldToFilter($code, array('in'=>$value));
        }

        /** Avoid current product */
        $collection->addFieldToFilter('entity_id', array('nin'=>$this->getProduct()->getId()));
    }
}