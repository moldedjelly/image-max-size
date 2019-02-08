<?php
/**
 * ImageMaxSize plugin for Craft CMS 3.x
 *
 * Image Max Size
 *
 * @link      http://moldedjelly.com
 * @copyright Copyright (c) 2019 Mat Johnson
 */

namespace moldedjelly\imagemaxsize;

use moldedjelly\imagemaxsize\services\ImageMaxSize as ImageMaxSizeService;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\elements\Asset;
use craft\events\AssetEvent;

use yii\base\Event;

/**
 * Class ImageMaxSize
 *
 * @author    Mat Johnson
 * @package   ImageMaxSize
 * @since     1.0.0
 *
 * @property  ImageMaxSizeService $imageMaxSize
 */
class ImageMaxSize extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ImageMaxSize
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Asset::class,
            Asset::EVENT_BEFORE_HANDLE_FILE,
            function(AssetEvent $event) {
              ImageMaxSize::getInstance()->imageMaxSize->beforeHandleAssetFile($event);
            }
        );

        Craft::info(
            Craft::t(
                'image-max-size',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
