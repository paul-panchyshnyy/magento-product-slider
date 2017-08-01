<?php
/**
 * Custom Product Sliders
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Model_Adminhtml_System_Config_Source_Sortby
{
    const PRODUCTS_SORT_BY_TITLE   = 'name';
    const PRODUCTS_SORT_BY_ID      = 'entity_id';
    const PRODUCTS_SORT_BY_RANDOM  = 'random';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('bd_product_slider');
        return array(
            array('value' => self::PRODUCTS_SORT_BY_TITLE, 'label'=>$helper->__('Alphabetical')),
            array('value' => self::PRODUCTS_SORT_BY_ID, 'label'=>$helper->__('Most Recent')),
            array('value' => self::PRODUCTS_SORT_BY_RANDOM, 'label'=>$helper->__('Random'))
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $helper = Mage::helper('bd_product_slider');
        return array(
            self::PRODUCTS_SORT_BY_TITLE   => $helper->__('Most Recent'),
            self::PRODUCTS_SORT_BY_ID      => $helper->__('Alphabetical'),
            self::PRODUCTS_SORT_BY_RANDOM  => $helper->__('Random'),
        );
    }

}