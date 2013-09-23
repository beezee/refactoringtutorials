<?php

class PHPRefactoringWidget extends RefactoringWidget
{

    public function getStepValidationAssertions()
    {
        return array();
    }

    public function processSubmissionForStep($stepNumber)
    {
        if (!isset($this->stepValidationAssertions[$stepNumber]))
            throw new CHttpException(404);
        $validator = new PHPRefactoringStepValidator();
        $validator->code = Yii::App()->request->getPost('code')
            .' '.$this->stepValidationAssertions[$stepNumber];
        if (!$validator->validateStep())
            return array('errors' => $validator->errors);
        return array();
    }
}