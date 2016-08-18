<?php
    namespace grsolution\fileManager\widgets\uploadPictureWidget;
    use yii\web\AssetBundle;

    class UploadPictureAsset extends AssetBundle{
        public $sourcePath = '@grsolution/fileManager/widgets/uploadPictureWidget/assets/';

        public $css = ['uploadPicture.css'];
        public $js = ['uploadPicture.js'];

        public $depends = [
            'backend\assets\AppAsset'
        ];
    }