<?php
/**
 * Copyright © Tuna, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tuna\WysiwygInitialer\Block;

use Magento\Framework\View\Element\Template;
use Magento\Ui\Block\Wysiwyg\ActiveEditor;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Magento\Framework\View\Asset\Repository as AssetRepo;

/**
 * Class Wysiwyg
 * @package Tuna\WysiwygInitialer\Block
 */
class Wysiwyg extends Template
{
    /**
     * @var ActiveEditor
     */
    private $activeEditor;

    /**
     * @var WysiwygConfig
     */
    private $wysiwygConfig;

    /**
     * @var AssetRepo
     */
    private $assetRepo;

    public function __construct(
        Template\Context $context,
        ActiveEditor $activeEditor,
        WysiwygConfig $wysiwygConfig,
        AssetRepo $assetRepo,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->activeEditor = $activeEditor;
        $this->assetRepo = $assetRepo;
        $this->wysiwygConfig = $wysiwygConfig;
    }

    public function getBlockDummyText()
    {
        return 'This is wysiwyg test';
    }

    /**
     * @return string
     */
    public function getCurrentEditorPath()
    {
        return $this->activeEditor->getWysiwygAdapterPath();
    }

    /**
     * @return \Magento\Framework\DataObject
     */
    public function getWysiwygConfig()
    {
        return $this->wysiwygConfig->getConfig();
    }

    /**
     * @return false|string
     */
    public function getWysiwygConfigJsonEncoded()
    {
        return json_encode($this->wysiwygConfig->getConfig()->getData());
    }

    /**
     * @return string
     */
    public function getWysiwygCssUrl()
    {
        return $this->assetRepo->getUrl('mage/adminhtml/wysiwyg/tiny_mce/themes/ui.css');
    }

    /**
     * Init config for this test only
     *
     * @param void
     * @return string
     */
    public function tinyMCE4CustomConfig()
    {
        $config = [
            "width" => "99%",
            "height" => "400px",
            'menubar' => true,
            'tinymce4' => [
                'toolbar' => 'formatselect | bold italic underline | alignleft aligncenter alignright | '
                    . 'bullist numlist | link table charmap',
                'plugins' => implode(
                    ' ',
                    [
                        'advlist',
                        'autolink',
                        'lists',
                        'link',
                        'charmap',
                        'media',
                        'noneditable',
                        'table',
                        'contextmenu',
                        'paste',
                        'code',
                        'help',
                        'table'
                    ]
                ),
                "content_css" => $this->getWysiwygCssUrl()
            ]
        ];

        return json_encode($config, JSON_HEX_TAG);
    }

    /**
     * tinymce3 config
     *
     * @return string
     */
    public function tinyMCE3CustomConfig()
    {
        $config = [
            "width" => "99%",
            'height'=> '200px',
            'menubar' => false,
            'plugins' => [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            "content_css" => $this->getWysiwygCssUrl(),
            'toolbar' => 'undo redo | formatselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | removeformat'
        ];

        return json_encode($config, JSON_HEX_TAG);
    }
}
