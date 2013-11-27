<?php

class PHPRefactoringStepValidator extends RefactoringStepValidator
{
    private $_code;
    
    public function setCode($code)
    {
        $this->_code = preg_replace('/\?\>$/', '', $code).'?>';
    }
    
    public function getCode()
    {
        return $this->_code;
    }
    
    private function extractErrors($result)
    {
        if (isset($result['error']))
            return $this->errors = array($result['error']);
        if ($result['result'] != 1)
            return $this->errors = json_decode($result['result'], true);
    }
    
    public function validateStep()
    {
        $curl = new Curl();
        $data = array('code' => $this->code, 'phptag' => 'no');
        $result = json_decode($curl->post('http://phpfiddle.org/api/run/code/json', $data)->body,
                              true);
        $this->extractErrors($result);
        return empty($this->errors);
    }
}
