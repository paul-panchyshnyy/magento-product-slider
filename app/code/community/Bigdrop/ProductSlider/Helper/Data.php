<?php
/**
 * Custom Product Sliders
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Config path for the global settings
     */
    const XML_PATH_SLIDER_SETTINGS = 'product_sliders/';

    /**
     * Gets product not-loaded attributes
     *
     * @param Mage_Catalog_Model_Product $product
     * @param $attribute
     * @param bool $flag
     * @return mixed
     */
    public function getProductAttribute($product, $attribute, $flag = true)
    {
        $value = $product->getResource()->getAttributeRawValue($product->getId(), $attribute, $product->getStoreId());

        if ($flag == true) {
            $label = $product->getResource()->getAttribute($attribute)->getSource()->getOptionText($value);
            return $label;
        }

        return $value;
    }

    /**
     * Retrieves global settings
     *
     * @return Varien_Object
     */
    public function getGlobalSettings()
    {
        return new Varien_Object(Mage::getStoreConfig(self::XML_PATH_SLIDER_SETTINGS . 'settings'));
    }

    /**
     * Retrieves Slider configuration by code
     *
     * @param $code
     * @return Varien_Object
     */
    public function getSliderConfig($code)
    {
        return new Varien_Object(Mage::getStoreConfig(self::XML_PATH_SLIDER_SETTINGS . $code));
    }
}