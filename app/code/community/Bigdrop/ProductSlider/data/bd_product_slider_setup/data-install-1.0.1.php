<?php
/**
 * Custom Product Sliders
 * Give product sliders permissions
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$adminVersion = Mage::getConfig()->getModuleConfig('Mage_Admin')->version;
// Checking Admin's module version
if (version_compare($adminVersion, '1.6.1.2', '>=')) {
    $blockNames = array(
        'bd_product_slider/featured',
        'bd_product_slider/sale',
        'bd_product_slider/newest',
        'bd_product_slider/recently',
        'bd_product_slider/bestsellers'
    );
    foreach ($blockNames as $blockName) {
        $whiteListBlock = Mage::getModel('admin/block');
        $whiteListBlock->setData(
            array(
                'block_name' => $blockName,
                'is_allowed' => 1
            )
        );
        $whiteListBlock->save();
    }
}