<?php
    namespace common\components\fileManager\models;
    use Yii;
    use yii\base\Model;

    /**
     * Class FileManagerModel
     * @package common\components\fileManager\models
     *
     * @property \yii\web\UploadedFile $file
     */
    abstract class FileManagerModel extends Model{
        public $file;
        public $savePath;
        public $validationRules;

        public function init(){
            parent::init();
            $this->validationRules = [
                array_merge(
                    [[Yii::$app->fileManager->getInputName()]],
                    Yii::$app->fileManager->validationRules,
                    $this->validationRules
                )
            ];
//            $this->validationRules = [
//                [['file'], 'file', 'maxSize' => 1024 * 1024, 'extensions' => 'png, jpg']
//            ];
        }

        /**
         * @param $directory
         *
         * @return FileManagerModel
         */
        abstract public function uploadFile($directory);

        abstract public function removeFile($path);
    }