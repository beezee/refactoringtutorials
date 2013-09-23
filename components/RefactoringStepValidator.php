<?php

class RefactoringStepValidator extends CComponent
{
    
    public $errors;
    
    public function init(){}
    
    public function validateStep()
    {
        $this->errors[] = 'Step validator must be overridden';
    }
}