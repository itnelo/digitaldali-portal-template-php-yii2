<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public $_segments = [];
    public $_image_name = '';
    public $_uploaded_url = '';

    const DIR_UPLOADS = 'uploads';
    const DIR_IMAGES = 'images';

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function addSegments($segments = []) {
        if (! is_array($segments)) $segments = (array)$segments;
        $this->_segments = array_merge($this->_segments, $segments);
    }

    public function uploadedUrl() {
        return \Yii::getAlias('@web') . $this->_uploaded_url;
    }

    public function upload()
    {
        if ($this->validate()) {
            $image_dir = \Yii::getAlias('@webroot');
            $this->_uploaded_url = implode(DIRECTORY_SEPARATOR, ['', self::DIR_UPLOADS, self::DIR_IMAGES, '']);
            foreach ($this->_segments as $segment) {
                $this->_uploaded_url .= $segment . DIRECTORY_SEPARATOR;
            }
            BaseFileHelper::createDirectory($image_dir . $this->_uploaded_url, 0775, true);
            $this->_uploaded_url .= md5($this->_image_name . time()) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($image_dir . $this->_uploaded_url);
            return true;
        } else {
            return false;
        }
    }
}