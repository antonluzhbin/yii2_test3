<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;    
use yii\db\Expression;
use yii\jui\DatePicker;

$form = ActiveForm::begin([
    'id' => 'ride-form',
    'enableClientValidation'=>false,
    'validateOnSubmit' => true
    ]); ?>

<?php echo $form->field($model, 'name')->textInput(array('class' => 'span8', 'style' => 'width: 200px;'))->label('Название'); ?>
<?php echo $form->field($model, 'created')->textInput(array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true'))->label('Дата создания записи'); ?>
<?php echo $form->field($model, 'updated')->textInput(array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true'))->label('Дата обновления записи'); ?>
<?php echo $form->field($model, 'preview')->textInput(array('class' => 'span8', 'style' => 'width: 200px;'))->label('Путь к картинке превью книги'); ?>
Дата выхода книги<br>
<?php 
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'date',
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd'
        ]);
?>
<?php echo $form->field($model, 'author_id')->dropDownList($author , array('style' => 'width: 200px;'))->label('Автор'); ?>

    <div class="form-actions">
        <?php echo Html::submitButton('Submit', null, null, array('class' => 'btn btn-primary')); ?>
    </div>

<?php ActiveForm::end(); ?>
