<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \common\models\PortfolioImages */
?>

<?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['class' => 'fill-up']]); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-teal-300">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Метаданные изображения</h6>
            </div>
            <div class="modal-body">
                <?= $form->field($model, 'alt') ?>
                <?= $form->field($model, 'title') ?>
            </div>

            <div class="modal-footer">
                <?= Html::submitButton('Сохранить', ['class' => 'btn bg-teal-300', 'id' => 'edit_image_button']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>