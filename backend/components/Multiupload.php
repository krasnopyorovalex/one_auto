<?php

namespace backend\components;

use Yii;
use yii\base\Action;
use yii\web\UploadedFile;
use common\models\GalleryImages;
use yii\imagine\Image;
use yii\helpers\FileHelper;

class Multiupload extends Action
{
    const DELIMITER = '/';
    public function run()
    {
        $gallery_id = Yii::$app->request->post('id');
        $path = Yii::getAlias('@frontend'.GalleryImages::PATH . $gallery_id . self::DELIMITER);
        if (!file_exists($path)) FileHelper::createDirectory($path, 755, true);

        $image = new GalleryImages();
        $image->file = UploadedFile::getInstancesByName('file');
        //save to DB
        $image['gallery_id'] = $gallery_id;
        $image['basename'] = 'img_' . Yii::$app->getSecurity()->generateRandomString(25);
        $image['ext'] = $image->file[0]->extension;
        $image['publish'] = 1;

        if($image->validate()){
            $image->file[0]->saveAs($path . $image['basename'] . '.' . $image['ext']);
            //thumb
            Image::thumbnail($path . $image['basename'] . '.' . $image['ext'], 450, 225)
                ->save($path . $image['basename'] . '_450_225.' . $image['ext'], ['quality' => 100]);
            return $image->save();
        }
    }
} 