<?php

class RefactoringsContainer extends CComponent
{
    
    private $_refactorings;
    
    public function init()
    {
    
    }
    
    public function getRefactorings()
    {
        if ($this->_refactorings)
            return $this->_refactorings;
        $this->raiseEvent('registerRefactorings', new CEvent($this));
        return $this->_refactorings;
    }
    
    public function addRefactoring(Refactoring $refactoring)
    {
        $this->_refactorings[get_class($refactoring)]
            = $refactoring;
    }
}