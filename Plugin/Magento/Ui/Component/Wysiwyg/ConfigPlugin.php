<?php
/**
 * Copyright © Tuna, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tuna\WysiwygInitialer\Plugin\Magento\Ui\Component\Wysiwyg;

/**
 * Class ConfigPlugin
 * @package Tuna\WysiwygInitialer\Plugin\Magento\Ui\Component\Wysiwyg
 */
class ConfigPlugin
{
    /**
     * @var \Magento\Ui\Block\Wysiwyg\ActiveEditor
     */
    protected $activeEditor;

    public function __construct(
        \Magento\Ui\Block\Wysiwyg\ActiveEditor $activeEditor
    ) {
        $this->activeEditor = $activeEditor;
    }

    /**
     * Enable variables & widgets on product edit page
     *
     * @param \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface
     * @param array $data
     * @return array
     */
    public function beforeGetConfig(
        \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface,
        $data = []
    ) {
        $data['add_variables'] = true;
        $data['add_widgets'] = true;
        return [$data];
    }

    /**
     * Return WYSIWYG configuration
     *
     * @param \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface
     * @param \Magento\Framework\DataObject $result
     * @return \Magento\Framework\DataObject
     */
    public function afterGetConfig(
        \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface,
        \Magento\Framework\DataObject $result
    ) {
        // Get current wysiwyg adapter's path
        $editor = $this->activeEditor->getWysiwygAdapterPath();
        // Is the current wysiwyg tinymce v4?
        if (strpos($editor,'tinymce4Adapter')) {
            $settings = $result->getData('settings');
            if (!is_array($settings)) {
                $settings = [];
            }
            // configure tinymce settings
            $settings['menubar'] = true;
            $settings['image_advtab'] = true;
            $settings['plugins'] = 'advlist autolink code colorpicker directionality hr imagetools link media noneditable paste print table textcolor toc visualchars anchor charmap codesample contextmenu fullpage help image insertdatetime lists nonbreaking pagebreak preview searchreplace template textpattern visualblocks wordcount magentovariable magentowidget';
            $settings['toolbar1'] = 'magentovariable magentowidget | formatselect | styleselect | fontsizeselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent';
            $settings['toolbar2'] = ' undo redo  | link anchor table charmap | image media insertdatetime | widget | searchreplace visualblocks  help | hr pagebreak';
            $result->setData('settings', $settings);
            return $result;

        } elseif (strpos($editor,'tinymce3Adapter')) { // don't make any changes if the current wysiwyg editor is not tinymce 4
            return $result;
        }
    }
}
