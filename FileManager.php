<?php
    namespace common\components\fileManager;
    use common\components\fileManager\models\FileManagerModel;
    use yii\base\Object;
    use yii\helpers\FileHelper;

    /**
     * Class FileManager
     * @package common\components\fileManager
     *
     * @property string $storagePath
     * @property string $storageUrl;
     */
    class FileManager extends Object{
        public    $storagePath;
        public    $storageUrl;
        protected $inputName = 'file';
        public $validationRules = ['file', 'maxFiles'=> 1, 'maxSize'=> 1024];

        /**
         * @inheritdoc
         */
        public function init(){
            parent::init();
        }


        public function uploadFile(FileManagerModel $model, $targetDirectory){
            if($model->validate()){
                $today = date('Y-m-d');
                $directory = $this->storagePath.$targetDirectory.DIRECTORY_SEPARATOR.$today;
                if(!is_dir($directory)){
                    $this->createDirectory($directory);
                }
                if($model->uploadFile($directory.DIRECTORY_SEPARATOR)->hasErrors()){
                    return $this->sendResponse($model->getErrors($this->inputName));
                }
                return $this->sendResponse($model->savePath);
            }
            return $this->sendResponse($model->getErrors($this->inputName));
        }

        /**
         * @param string $file
         *
         * @return string
         */
        public function getPath($file){
            return $this->storagePath.$file;
        }

        /**
         * @param string $file
         *
         * @return string
         */
        public function getUrl($file){
            return $this->storageUrl.$file;
        }

        /**
         * @return string
         */
        public function getInputName(){
            return $this->inputName;
        }

        /**
         * @param $data
         *
         * @return string
         */
        public function sendResponse($data){
            return json_encode($data);
        }

        public function createDirectory($newDirectory, $mod = 0777, $recursive = true){
            FileHelper::createDirectory($newDirectory, $mod, $recursive);
        }
    }