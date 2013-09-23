<?php

class RefactoringWidget extends CWidget
{
    private $_stepNumber;
    public $startingCode = '';
    public $title = '';
    public $viewPath = '';
    public $submissionResult = false;

    public function init()
    {
    
    }
    
    public function render()
    {
    
    }
    
    public function getCode()
    {
        return Yii::App()->request->getPost('code', $this->startingCode);
    }
    
    public function showOverView()
    {
        Yii::App()->controller->render('//refactorings/Overview');
    }
    
    public function getStepView()
    {
        return $this->_stepNumber
            ? $this->viewPath.'step_'.$this->_stepNumber
            : $this->viewPath.'description';
    }
    
    public function enforcePostedCodeAfterFirstStep()
    {
        if (!Yii::App()->request->getPost('code') and $this->_stepNumber > 1)
            Yii::App()->controller->redirect(array('refactoring/step',
                                'refactoringSlug'
                                    => Yii::App()->request->getQuery('refactoringSlug'),
                                'stepNumber' => 1));
    }
    
    public function showStep($stepNumber)
    {
        Yii::App()->controller->pageTitle
            = Yii::App()->controller->refactoringName.' - Step '.strip_tags($stepNumber);
        $this->_stepNumber = $stepNumber;
        if (Yii::App()->request->getPost('code'))
            $this->submissionResult = $this->processSubmissionForStep($stepNumber);
        if (!Yii::App()->controller->getViewFile($this->stepView))
            throw new CHttpException(404);
        Yii::App()->controller->render('//refactorings/Step');
    }
    
    public function processSubmissionForStep($stepNumber)
    {
        throw new Exception('processSubmissionForStep must be overloaded');
    }
}