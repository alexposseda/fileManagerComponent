<?php
    namespace common\components\fileManager\actions;
    use Yii;
    use yii\base\Action;
    use yii\web\UploadedFile;

    class UploadAction extends Action{
        public $uploadPath;
        public $uploadModel;

        public function run(){
            $this->uploadModel->file = UploadedFile::getInstanceByName(Yii::$app->fileManager->getInputName());
            $result = Yii::$app->fileManager->uploadFile($this->uploadModel, $this->uploadPath);
            return var_dump($result);
        }
    }