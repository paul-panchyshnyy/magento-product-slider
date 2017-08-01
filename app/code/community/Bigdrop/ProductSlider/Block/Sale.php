<?php
/**
 * Custom Product Sliders
 * Sale products
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Sale extends Bigdrop_ProductSlider_Block_Slider_Abstract
{
    protected $_code = 'sale';

    /**
     * Preparing Sale products collection
     *
     * @param $collection
     */
    protected function _applyFilterToCollection($collection)
    {
        $collection->getSelect()->where('price_index.final_price < price_index.price');
    }
}