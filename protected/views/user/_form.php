<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->textField($model,'user',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nama'); ?>
		<?php echo $form->textField($model,'nama',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jk'); ?>
		<?php echo $form->dropdownlist($model,'jk',array('male'=>'Male','female'=>'Female'),array('style'=>'width:250px')); ?>
		<?php echo $form->error($model,'jk'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tglLahir'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
			    'language'=>'id',
                'model'=>$model,
              	'attribute'=>'tglLahir',
              	'value'=>$model->tglLahir,
             	'options'=>array(
                	'showAnim'=>'fold',
                	'dateFormat'=>'yy-mm-dd'
              	),
            	'htmlOptions'=>array(
               		'style'=>'height:15px;',
            	),
          	));
		?>
	
	<?php echo $form->error($model,'tglLahir'); ?>
	</div>
	
	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
</div> <!--form -->