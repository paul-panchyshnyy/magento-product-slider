<?php
/**
 * Custom Product Sliders
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$attribute = Mage::getModel('catalog/resource_eav_attribute')
    ->loadByCode(Mage_Catalog_Model_Product::ENTITY, 'is_featured');

if (!$attribute->getId()) {
    $installer = Mage::getResourceModel('catalog/setup', 'catalog_setup');
    $installer->startSetup();

    /** Adding attribute 'is_featured' to the Product entity */
    $data = array(
        'group'                      => 'General',
        'frontend'                   => '',
        'source'                     => 'eav/entity_attribute_source_boolean',
        'label'                      => 'Featured',
        'note'                       => 'Is this Product is featured',
        'input'                      => 'select',
        'type'                       => 'int',
        'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'                    => true,
        'required'                   => false,
        'searchable'                 => false,
        'filterable'                 => false,
        'comparable'                 => false,
        'visible_on_front'           => false,
        'user_defined'               => false,
        'visible_in_advanced_search' => false,
        'is_html_allowed_on_front'   => false,
        'default'                    => 0,
    );



    $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'is_featured', $data);
    $installer->endSetup();
}