<?php
    namespace grsolution\fileManager\widgets\uploadPictureWidget;

    use Yii;
    use yii\base\Widget;
    use yii\web\View;

    class UploadPictureWidget extends Widget{
        public $uploadUrl;
        public $removeUrl;
        public $targetInputId;
        public $pictures;
        public $picturesCount = 1;

        public function init(){
            parent::init();
        }

        public function run(){
            UploadPictureAsset::register(Yii::$app->getView());
            $script = <<<JS
var uploadUrl = "{$this->uploadUrl}";
var removeUrl = "{$this->removeUrl}";
var targetInputId = "{$this->targetInputId}";
var maxPictureCount = "{$this->picturesCount}";

if($('#'+targetInputId).val() != '' && JSON.parse($('#'+targetInputId).val()).length >= maxPictureCount){
    $('#uploadPictureInput').attr('disabled', 'disabled');
}

if($('#'+targetInputId).val() != ''){
    
}
JS;
            Yii::$app->view->registerJs($script, View::POS_END);
            if(!$this->pictures){
                $uploadsFile = Yii::$app->session->get('uploadedFiles')[Yii::$app->controller->id];
                foreach($uploadsFile as $file){
                     $files[] = Yii::$app->fileManager->storageUrl.$file;
                }
                $this->pictures = $files;
            }

            return $this->render('uploadPicture', ['pictures' => $this->pictures]);
        }
    }