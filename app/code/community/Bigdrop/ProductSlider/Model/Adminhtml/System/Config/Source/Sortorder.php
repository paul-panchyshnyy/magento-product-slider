<?php
/**
 * Custom Product Sliders
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Model_Adminhtml_System_Config_Source_Sortorder
{
    const PRODUCTS_SORT_ORDER_ASC  = 'asc';
    const PRODUCTS_SORT_ORDER_DESC = 'desc';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('bd_product_slider');
        return array(
            array('value' => self::PRODUCTS_SORT_ORDER_ASC, 'label'=>$helper->__('Ascending')),
            array('value' => self::PRODUCTS_SORT_ORDER_DESC, 'label'=>$helper->__('Descending')),
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
            self::PRODUCTS_SORT_ORDER_ASC  => $helper->__('Descending'),
            self::PRODUCTS_SORT_ORDER_DESC => $helper->__('Ascending'),
        );
    }

}