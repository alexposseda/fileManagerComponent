<?php
    /**
     * @var array $pictures
     */
    use yii\bootstrap\Html;
?>
<div class="pictureUpload-wrap">
    <div class="panel panel-default">
        <div class="panel-heading">Изображения</div>
        <div class="panel-body relative">
            <?php if(empty($pictures)):?>
            <div class="alert alert-info"><strong>Ни одного файла не загружено</strong></div>
            <?php endif;?>
            <div id="pictures-wrapper">
                <?php
                    if(is_array($pictures)):
                        foreach($pictures as $picture):
                            ?>
                            <div class="previewBox">
                                <div class="img-wrap">
                                    <img src="<?= Yii::$app->params['storage']['url'].$picture ?>">
                                </div>
                                <button type="button" class="btn btn-danger removePicture" data-path="<?= $picture ?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                            <?php
                        endforeach;
                    endif;
                ?>
            </div>
            <div id="preloader" class="preloader" style="display: none">
                <span>loading ...</span>
            </div>
        </div>
        <div class="panel-footer">
            <?= Html::fileInput(Yii::$app->fileManager->getInputName(), null, ['class' => 'form-control', 'id' => 'uploadPictureInput']) ?>
        </div>
    </div>
</div>
