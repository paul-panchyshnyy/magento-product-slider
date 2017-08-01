<?php
/**
 * Custom Product Sliders
 * Recently viewed products
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Recent extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'recently_viewed';

    /**
     * Disable block caching
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setCacheLifetime(null);
    }

    /**
     * Preparing Recently viewed products collection
     */
    protected function _prepareSliderCollection()
    {
        return $this->getLayout()->createBlock('reports/product_viewed')->getItemsCollection();
    }
}