<?php

class RefactoringController extends Controller
{
    
    public $refactoringSlug = '';
    public $widget;
    
    public function getRefactoringName()
    {
        return ucwords(join(' ', explode('-', $this->refactoringSlug)));
    }

    public function getRefactoringWidgetClassName()
    {
        return str_replace(' ', '', $this->refactoringName).'RefactoringWidget';
    }
    
    public function getRefactoringWidget()
    {
        if (!file_exists(Yii::getPathOfAlias('application.components.'
                    .$this->refactoringWidgetClassName).'.php'))
            throw new CHttpException(404, 'That refactoring doesn\'t exist yet.');
        return $this->widget = Yii::createComponent($this->refactoringWidgetClassName);
    }
    
    public function actionIndex($refactoringSlug)
    {
        $this->refactoringSlug = $refactoringSlug;
        $this->refactoringWidget->showOverview();
    }
    
    public function actionStep($refactoringSlug, $stepNumber)
    {
        $this->refactoringSlug = $refactoringSlug;
        $this->refactoringWidget->showStep($stepNumber);
    }
}