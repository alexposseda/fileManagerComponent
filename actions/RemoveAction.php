<?php
    namespace common\components\fileManager\actions;
    use Yii;
    use yii\base\Action;

    class RemoveAction extends Action{
        public function run(){
            //todo проверить на введенное имя!
            return Yii::$app->fileManager->removeFile(Yii::$app->request->post(Yii::$app->fileManager->getInputName()));
        }
    }