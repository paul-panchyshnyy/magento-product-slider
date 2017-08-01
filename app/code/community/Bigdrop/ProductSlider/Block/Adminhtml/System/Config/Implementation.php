<?php
/**
 * Custom Product Sliders
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Bigdrop_ProductSlider_Block_Adminhtml_System_Config_Implementation
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setCanUseWebsiteValue(false)->setCanUseDefaultValue(false)->setScope(false);
        return parent::render($element);
    }

    /**
     * Returns help code for implementation Product Sliders on the site
     *
     * @return string
     */
    protected function _getElementHtml()
    {
        return $this->getLayout()->createBlock('adminhtml/template')
            ->setTemplate('bigdrop/product_slider/implementation.phtml')->toHtml();
    }
}