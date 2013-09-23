<?php

class ExtractMethodRefactoringWidget extends PHPRefactoringWidget
{
    public $title = 'Extract Method';
    public $viewPath = '//refactorings/extract_method/';
    public $startingCode = '
<?php
    class Invoice
    {
        public $name;
        public $orders = array(
            array("amount" => 3),
            array("amount" => 4.50),
            array("amount" => 5.25),
        );
        
        public function __construct($name)
        {
            $this->_name = $name;
        }
        
        public function print_owing()
        {
            $outstanding = 0.0;
            
            //print banner
            echo "*******************";
            echo "***Customer Owes***";
            echo "*******************";
            
            //calculate outstanding
            foreach($this->orders as $order)
                $outstanding += $order["amount"];
            
            //print details
            echo "name: ".$this->name;
            echo "amount: ".$outstanding;
        }
    }';
    
    public function getStepValidationAssertions()
    {
        $invoiceTester = '
            class InvoiceTester extends Invoice
            {
                public $print_banner_called = false;
                public $print_owing_called = false;
                
                public function print_banner()
                {
                    $this->print_banner_called = true;
                    parent::print_banner();
                }
                
                public function print_owing()
                {
                    $this->print_owing_called = true;
                    parent::print_owing($amount);
                }
            }
        ';
        return array(
            1 => $invoiceTester.'
                $errors = array();
                $tester = new InvoiceTester("test");
                ob_start();
                $tester->print_owing();
                $out = ob_get_clean();
                if (!stristr($out, "***Customer"))
                    $errors[] = "print_owing should still print the banner";
                if ($tester->print_banner_called)
                    $errors[] = "print_owing should not yet call print_banner";
                ob_start();
                $tester->print_banner();
                $out = ob_get_clean();
                if (!stristr($out, "***Customer"))
                    $errors[] = "print_banner should print the banner";
                echo (count($errors) > 0)
                    ? json_encode($errors)
                    : 1;
            '
        );
    }
    
}