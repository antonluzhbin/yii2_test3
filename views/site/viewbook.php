<div style='padding: 50px;'>

<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;    
use yii\db\Expression;

$form = ActiveForm::begin([
    'id' => 'ride-form',
    'enableClientValidation'=>false,
    'validateOnSubmit' => true
    ]); ?>

<?php echo $form->field($model, 'name')->textInput(array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true'))->label('Название'); ?>
<?php echo $form->field($model, 'created')->textInput(array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true'))->label('Дата создания записи'); ?>
<?php echo $form->field($model, 'updated')->textInput(array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true'))->label('Дата обновления записи'); ?>
<?php echo $form->field($model, 'preview')->textInput(array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true'))->label('Путь к картинке превью книги'); ?>
<?php echo $form->field($model, 'date')->textInput(array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true'))->label('Дата выхода книги'); ?>
<?php echo 'Автор<br>' . Html::textInput('Автор', $author[$model->author_id], array('class' => 'span8', 'style' => 'width: 200px;', 'disabled' => 'true')); ?>

<?php ActiveForm::end(); ?>

</div>