<?php
namespace  Products\CustomField\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;

class NewField extends AbstractModifier
{// Components indexes
    const CUSTOM_FIELDSET_INDEX = 'custom_fieldset';

    // Fields names
    const FIELD_NAME_TEXT_VENDOR_NAME = 'vendor_name';
    const FIELD_NAME_TEXT_PRIORITY = 'priority';

    /**
     * @var \Magento\Catalog\Model\Locator\LocatorInterface
     */
    protected $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var array
     */
    protected $meta = [];

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        LocatorInterface $locator,
        ArrayManager $arrayManager,
        UrlInterface $urlBuilder
    ) {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Data modifier, does nothing in our example.
     *
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Meta-data modifier: adds ours fieldset
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $this->meta = $meta;
        $this->addCustomFieldset();

        return $this->meta;
    }

    /**
     * Merge existing meta-data with our meta-data (do not overwrite it!)
     *
     * @return void
     */
    protected function addCustomFieldset()
    {
        $this->meta = array_merge_recursive(
            $this->meta,
            [
                static::CUSTOM_FIELDSET_INDEX => $this->getFieldsetConfig(),
            ]
        );
    }

    /**
     * Declare ours fieldset config
     *
     * @return array
     */
    protected function getFieldsetConfig()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Field'),
                        'componentType' => Fieldset::NAME,
                        'dataScope' => static::DATA_SCOPE_PRODUCT, // save data in the product data
                        'provider' => static::DATA_SCOPE_PRODUCT . '_data_source',
                        'ns' => static::FORM_NAME,
                        'collapsible' => true,
                        'sortOrder' => 10,
                        'opened' => true,
                    ],
                ],
            ],
            'children' => [
                static::FIELD_NAME_TEXT_VENDOR_NAME => $this->getVendorNameConfig(20),
                static::FIELD_NAME_TEXT_PRIORITY => $this->getPriorityConfig(20),
            ],
        ];
    }
    protected function getVendorNameConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Vendor Name'),
                        'formElement' => Field::NAME,
                        'componentType' => Input::NAME,
                        'dataScope' => static::FIELD_NAME_TEXT_VENDOR_NAME,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];
    }
    protected function getPriorityConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Priority'),
                        'formElement' => Field::NAME,
                        'componentType' => Input::NAME,
                        'dataScope' => static::FIELD_NAME_TEXT_PRIORITY,
                        'dataType' => Number::NAME,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];
    }



}