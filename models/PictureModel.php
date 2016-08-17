<?php
    namespace common\components\fileManager\models;
    use Yii;

    /**
     * Class PictureModel
     * @package common\components\fileManager\models
     *
     * @property \yii\web\UploadedFile $file
     */
    class PictureModel extends FileManagerModel{
        public function rules(){
            return $this->validationRules;
        }

        /**
         * @param $directory
         *
         * @return $this
         */
        public function uploadFile($directory){
            $fileName = uniqid(time(), true);
            $this->savePath = $directory.$fileName.'.'.$this->file->extension;
            if(!$this->file->saveAs(Yii::$app->fileManager->storagePath.$this->savePath)){
                $this->addError('file', 'Upload failed');
            }

            return $this;
        }
    }