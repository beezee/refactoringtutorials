<?php
if ($this->widget->isSuccess) : ?>
<input class="btn btn-large btn-success" value="Great job! On to the next step" onclick="<?php
        echo "(function(\$){\$('#code-form').submit();}(jQuery));"; ?>" /><br /><br />
<?php
else: 
$this->renderPartial($this->widget->stepView);
endif;

$form = $this->beginWidget('CActiveForm',
            array('action' => ($this->widget->isSuccess)
                    ? array('refactoring/step',
                            'refactoringSlug' => Yii::App()->request->getQuery('refactoringSlug'),
                            'stepNumber' => Yii::App()->request->getQuery('stepNumber') + 1)
                    : Yii::App()->request->url,
                  'id' => 'code-form'));
echo CHtml::textarea('code', $this->widget->code, array('class' => 'hidden',
                                                              'id' => 'code')); ?>
<div id="editor"></div>
<?php if ($this->widget->submissionResult
        and is_array(CHtml::value($this->widget->submissionResult, 'errors'))) : ?>
<p class="alert alert-error"><?php echo join('<br />', $this->widget->submissionResult['errors']); ?></p>
<?php endif;?>
<div class="buttons row-fluid">
    <?php if ($this->widget->isSuccess) : ?>
    <input type="hidden" name="changestep" value="yes" />
    <?php else: ?>
    <input class="pull-right btn btn-primary" value="Submit" onclick="<?php
    echo "(function(\$){\$('#code').val(ace.edit('editor').getSession().getValue());"
            ."\$('#code-form').submit();}(jQuery));"; ?>" />
    <?php endif; ?>
</div>
<?php $this->endWidget(); ?>                                                  
<!-- <script src="<?php echo Yii::App()->baseUrl;
    ?>/static/js/ace.js" type="text/javascript" charset="utf-8"></script> -->
<script type="text/javascript" src="http://ace.ajax.org/build/src/ace.js"></script>
<?php Yii::App()->clientScript->registerScript('initEditor', 
        '(function($, exports, undefined){
            $("document").ready(function(){
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/monokai");
                editor.getSession().setMode("ace/mode/php");
                editor.getSession().setUseSoftTabs(false);
                editor.getSession().setValue($("#code").val());
            });
        }(jQuery, window));'); ?>