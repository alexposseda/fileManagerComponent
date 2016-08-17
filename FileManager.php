<?php
    namespace common\components\fileManager;
    use common\components\fileManager\models\FileManagerModel;
    use Yii;
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
        protected $inputName       = 'file';
        public    $validationRules = ['file', 'maxFiles' => 1, 'maxSize' => 1024];

        /**
         * @inheritdoc
         */
        public function init(){
            parent::init();
        }

        /**
         * @param FileManagerModel $model
         * @param string           $targetDirectory
         * @param bool             $sessionEnable
         *
         * @return string
         */
        public function uploadFile(FileManagerModel $model, $targetDirectory, $sessionEnable = false){
            if($model->validate()){
                $today = date('Y-m-d');
                $directory = $targetDirectory.DIRECTORY_SEPARATOR.$today;
                if(!is_dir($this->storagePath.$directory)){
                    $this->createDirectory($directory);
                }
                if($model->uploadFile($directory.DIRECTORY_SEPARATOR)->hasErrors()){
                    return $this->sendResponse($model->getErrors($this->inputName));
                }
                if($sessionEnable){
                    $this->saveToSession($model->savePath);
                }

                return $this->sendResponse($model->savePath);
            }

            return $this->sendResponse($model->getErrors($this->inputName));
        }

        public function removeFile($path){
            $fullPath = $this->storagePath.$path;
            if(file_exists($fullPath)){
                if(!unlink($fullPath)){
                    //todo разобраться с шаблоном для передачи результата
                    return $this->sendResponse('Can not delete file');
                }
            }

            $this->removeFromSession($path);
            return $this->sendResponse('success');
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

        /**
         * @param string $newDirectory
         * @param int    $mod
         * @param bool   $recursive
         */
        public function createDirectory($newDirectory, $mod = 0777, $recursive = true){
            FileHelper::createDirectory($this->storagePath.$newDirectory, $mod, $recursive);
        }

        /**
         * @param string $path
         */
        protected function saveToSession($path){
            $baseDir = substr($path, 0, strpos($path, DIRECTORY_SEPARATOR));
            $session = Yii::$app->session->get('uploadedFiles');
            if(!is_array($session)){
                $session = [];
            }
            $session[$baseDir][] = $path;
            Yii::$app->session->set('uploadedFiles', $session);
        }

        /**
         * @param string $path
         */
        protected function removeFromSession($path){
            $baseDir = substr($path, 0, strpos($path, DIRECTORY_SEPARATOR));
            $session = Yii::$app->session->get('uploadedFiles');
            if(!is_array($session)){
                $session = [];
            }else{
                if(is_array($session[$baseDir])){
                    foreach($session[$baseDir] as $index => $pathToFile){
                        if($path == $pathToFile){
                            array_splice($session[$baseDir], $index, 1);
                        }
                    }
                }
            }
            Yii::$app->session->set('uploadedFiles', $session);
        }
    }