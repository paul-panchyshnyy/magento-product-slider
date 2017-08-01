<?php
/**
 * Custom Product Sliders
 * Abstract class for all blocks
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

abstract class Bigdrop_ProductSlider_Block_Slider_Abstract extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'product_slider_block';

    /** @var null|Mage_Catalog_Model_Resource_Product_Collection  */
    protected $_collection;

    /** @var string Template definition */
    protected $_template = 'bigdrop/product_slider/default.phtml';

    /** @var string Slider's code */
    protected $_code = 'abstract';

    /**
     * @var Varien_Object
     */
    protected $_settings;

    /**
     * @var Varien_Object
     */
    protected $_sliderData;

    /**
     * Setting helper object to the block
     */
    protected function _construct()
    {
        parent::_construct();
        /** @var Bigdrop_ProductSlider_Helper_Data $_helper */
        $_helper = $this->helper('bd_product_slider');
        $this->_settings   = $_helper->getGlobalSettings();
        $this->_sliderData = $_helper->getSliderConfig($this->_code);
        $this->setCacheTags(array(self::CACHE_TAG));
        $this->setCacheLifetime(3600);
    }

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
            Mage::app()->getStore()->getCode(),
        );
    }

    /**
     * @return mixed|string
     */
    public function getSliderTitle()
    {
        if (!$this->_sliderData->getData('title')) {
            return $this->__('Product Slider');
        }

        return $this->_sliderData->getData('title');
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Retrieves standard product collection
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _getCollection()
    {
        return Mage::getResourceModel('catalog/product_collection');
    }

    /**
     * Retrieves collection's items qty
     *
     * @return int|mixed
     */
    protected function _getLimit()
    {
        if ($limit = $this->_settings->getLimit()) {
            return 36;
        }

        return 36;
    }

    /**
     * Retrieves sort by param
     *
     * @return mixed
     */
    protected function _getSortByParam()
    {
        return $this->_settings->getSortBy();
    }

    /**
     * Retrieves collection's sort order param
     *
     * @param $collection
     * @return mixed
     */
    protected function _setOrderToCollection($collection)
    {
        $param = $this->_getSortByParam();

        if ($param == Bigdrop_ProductSlider_Model_Adminhtml_System_Config_Source_Sortby::PRODUCTS_SORT_BY_RANDOM) {
            $collection->getSelect()->order(new Zend_Db_Expr('RAND()'));
            return $collection;
        }

        $collection->setOrder($param, $this->_settings->getSortOrder());

        return $collection;
    }

    /**
     * Apply visibility and stock status filters to collection
     *
     * @param $collection
     */
    protected function _applyStockVisibilityFilter($collection)
    {
        Mage::getSingleton('catalog/product_status')
            ->addVisibleFilterToCollection($collection);
        Mage::getSingleton('cataloginventory/stock')
            ->addInStockFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')
            ->addVisibleInCatalogFilterToCollection($collection);
    }

    /**
     * Assign a set of attributes to collection
     *
     * @param $collection
     */
    public function assignAttributes($collection)
    {
        $this->_addProductAttributesAndPrices($collection);
    }

    /**
     * Preparing product collection of the current Slider
     *
     * @return array|Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _prepareSliderCollection()
    {
        $collection = $this->_getCollection();

        if ($collection) {
            $this->assignAttributes($collection);
            $this->_applyStockVisibilityFilter($collection);
            $this->_setOrderToCollection($collection);
            $this->_applyFilterToCollection($collection);
            $collection->getSelect()->limit($this->_getLimit());
            $collection->getSelect()->group('entity_id');
        }

        return $collection;
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        if (!$this->_collection) {
            $this->_collection = $this->_prepareSliderCollection();
        }

        return parent::_beforeToHtml();
    }

    /**
     * Apply custom filters to the Slider's product collection
     *
     * @param $collection
     */
    protected function _applyFilterToCollection($collection)
    {
        return $collection;
    }

    /**
     * Retrieves Slider's products collection
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection|null
     */
    public function getSliderCollection()
    {
        return $this->_collection;
    }
}