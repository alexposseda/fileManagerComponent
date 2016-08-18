<?php
    namespace grsolution\fileManager\models;
    use Yii;
    use yii\base\Model;

    /**
     * Class FileManagerModel
     * @package grsolution\fileManager\models
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
        }

        /**
         * @param $directory
         *
         * @return FileManagerModel
         */
        abstract public function uploadFile($directory);
    }