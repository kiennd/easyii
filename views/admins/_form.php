<?php
use yii\easyii\models\Module;

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
?>
<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
<?= $form->field($model, 'username')->textInput($this->context->action->id === 'edit' ? ['disabled' => 'disabled'] : []) ?>
<?= $form->field($model, 'password')->passwordInput(['value' => '']) ?>
<?= $form->field($model, 'modules')->textInput(['value' => $model->modules, 'id'=>'module_field']) ?>



<table class="table table-hover">
    <thead>
    <tr>
        <th width="50">#</th>
        <th><?= Yii::t('easyii', 'Name') ?></th>
        <th><?= Yii::t('easyii', 'Title') ?></th>
        <th width="100"><?= Yii::t('easyii', 'Status') ?></th>

    </tr>
    </thead>
    <tbody>
     <?php foreach($modules as $module) : ?>
        <tr>
            <td><?= $module->primaryKey ?></td>
            <td><?= $module->name ?></td>
            <td><?= $module->title ?></td>
            <td class="status">
                <?= Html::checkbox('', $module->status == Module::STATUS_ON, [
                    'class' => 'module_item',
                    // 'onchange' => 'moduleChanged(this)',
                    'id' => $module->name,
                     'data-id' => $module->primaryKey,
                    // 'data-link' => Url::to(['/admin/admins/'])
                    // 'data-reload' => '1'
                ]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>



<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>



<script type="text/javascript">
    
    $('.module_item').change(function() {
        // this will contain a reference to the checkbox   
        if (this.checked) {
            // the checkbox is now checked 
             console.log('module changed'+$(this).data("id"));
            let oldVal = $(module_field).val();
            let newVal = oldVal + '-'+$(this).attr('id')+'-';
            $(module_field).val(newVal);

        } else {
            let oldVal = $(module_field).val();
            let newVal = oldVal.replace('-'+$(this).data("id")+'-','');
            $(module_field).val(newVal);
            
            // the checkbox is now no longer checked
        }
    });



</script>

