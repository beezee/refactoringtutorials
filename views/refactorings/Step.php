<div id="editor">
</div>
<?php $form = $this->beginWidget('CActiveForm',
            array('action' => Yii::App()->request->url,
                  'id' => 'code-form'));
echo CHtml::textarea('code', $this->widget->code, array('class' => 'hidden',
                                                              'id' => 'code')); ?>
<input class="btn btn-primary" value="Submit" onclick="<?php
    echo "(function(\$){\$('#code').val(ace.edit('editor').getSession().getValue());"
            ."\$('#code-form').submit();}(jQuery));"; ?>" />
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
        }(jQuery, window));');
$this->renderPartial($this->widget->stepView);?>
<pre><?php print_r($this->widget->submissionResult); ?></pre>