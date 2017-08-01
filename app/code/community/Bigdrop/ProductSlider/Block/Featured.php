<?php
/**
 * Custom Product Sliders
 * Featured products
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Featured extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'featured';

    /**
     * Preparing Featured products collection
     *
     * @param $collection
     */
    protected function _applyFilterToCollection($collection)
    {
        $collection->addAttributeToFilter('is_featured', array('eq' => 1));
    }
}