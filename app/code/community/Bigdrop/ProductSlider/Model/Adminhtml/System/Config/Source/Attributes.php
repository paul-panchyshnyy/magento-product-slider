<?php
/**
 * Custom Product Sliders
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Model_Adminhtml_System_Config_Source_Attributes
{
    protected $_options = array();

    /**
     * Transform product attributes array into the needed structure
     *
     * @param bool $asKeyValue
     * @return array
     */
    protected function _getTransformedProductAttributes($asKeyValue = false)
    {
        if (empty($this->_options)) {
            $attributes = Mage::getResourceModel('catalog/product_attribute_collection');

            foreach ($attributes as $attribute) {
                /** @var Mage_Catalog_Model_Resource_Eav_Attribute $attribute */
                if (!$attribute->getIsVisibleOnFront()) {
                    continue;
                }

                if ($asKeyValue) {
                    $options[$attribute->getAttributeCode()] = $attribute->getFrontendLabel();
                    continue;
                }

                $options[] = array(
                    'value' => $attribute->getAttributeCode(),
                    'label' => $attribute->getFrontendLabel()
                );
            }

            $this->_options = $options;
        }

        return $this->_options;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_getTransformedProductAttributes();
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_getTransformedProductAttributes(true);
    }
}