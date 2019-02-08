<?php
/**
 * ImageMaxSize plugin for Craft CMS 3.x
 *
 * Image Max Size
 *
 * @link      http://moldedjelly.com
 * @copyright Copyright (c) 2019 Mat Johnson
 */

namespace moldedjelly\imagemaxsize\services;

use moldedjelly\imagemaxsize\ImageMaxSize;

use Craft;
use craft\base\Component;
use craft\base\Image;
use craft\elements\Asset;
use craft\events\AssetEvent;
use craft\events\RegisterElementActionsEvent;
use craft\helpers\Image as ImageHelper;

use yii\web\BadRequestHttpException;

/**
 * @author    Mat Johnson
 * @package   ImageMaxSize
 * @since     1.0.0
 */
class Service extends Component
{
    // Public Methods
    // =========================================================================

    public function beforeHandleAssetFile(AssetEvent $event)
    {
        $asset = $event->sender;
        $filename = $asset->filename;
        $path = $asset->tempFilePath;
        if (!$path) {
            return;
        }

        // Should we be modifying images in this source?
        if (!ImageHelper::canManipulateAsImage(@pathinfo($path, PATHINFO_EXTENSION))) {
            return false;
        }

        list($width, $height, $type, $attr) = getimagesize($path);
        if ($width > 6000 || $height > 6000) {
          throw new BadRequestHttpException('Image "'.$filename.'" is too big!');
        }
    }


}
