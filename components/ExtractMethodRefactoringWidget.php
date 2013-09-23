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
            $this->name = $name;
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
                public $print_details_called = false;
                public $calculate_outstanding_called = false;
                public $arg_passed_to_print_details = false;
                public $orders = array(
                    array("amount" => 1),
                    array("amount" => .25),
                );
                
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
                
                public function calculate_outstanding()
                {
                    $this->calculate_outstanding_called = true;
                    return parent::calculate_outstanding();
                }
                
                public function print_details($outstanding="not specified")
                {
                    $this->arg_passed_to_print_details = $outstanding;
                    $this->print_details_called = true;
                    parent::print_details($outstanding);
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
                if (!$tester->print_banner_called)
                    $errors[] = "print_owing should call print_banner";
                if (substr_count($out, "***Customer") !== 1)
                    $errors[] = "print_owing should output the banner exactly once";
                ob_start();
                $tester->print_banner();
                $out = ob_get_clean();
                if (!stristr($out, "***Customer"))
                    $errors[] = "print_banner should print the banner";
                if (substr_count($out, "***Customer") !== 1)
                    $errors[] = "print_owing should output the banner exactly once"";
                echo (count($errors) > 0)
                    ? json_encode($errors)
                    : 1;
            ',
            2 => $invoiceTester.'
                $errors = array();
                $tester = new InvoiceTester("test");
                ob_start();
                $tester->print_owing();
                $out = ob_get_clean();
                if (!$tester->print_details_called)
                    $errors[] = "print_owing should call print_details";
                if (!stristr($out, "amount: 1.25"))
                    $errors[] = "print_owing should pass \$outstanding to print_details";
                if (substr_count($out, "amount:") !== 1)
                    $errors[] = "print_owing should output details exactly once"
                ob_start();
                $tester->print_details("wassappp!");
                $out = ob_get_clean();
                if (!stristr($out, "amount: wassappp!"))
                    $errors[] = "print_details should accept \$outstanding as an argument";
                if (substr_count($out, "amount:") !== 1)
                    $errors[] = "print_details should output details exactly once"
                echo (count($errors) > 0)
                    ? json_encode($errors)
                    : 1;
            ',
            3 => $invoiceTester.'
                $errors = array();
                $tester = new InvoiceTester("test");
                ob_start();
                $tester->print_details("ho");
                $out = ob_get_clean();
                if (stristr($out, "amount: ho"))
                    $errors[] = "print_details should no longer accept an argument";
                if (!$tester->calculate_outstanding_called)
                    $errors[] = "print_details should call calculate_outstanding";
                $tester->orders[] = array("amount" => 34);
                $outstanding = $tester->calculate_outstanding();
                if ($outstanding != 35.25)
                    $errors[] = "calculate_outstanding should return the sum amounts of all orders";
                ob_start();
                $tester->print_owing();
                $out = ob_get_clean();
                if ($tester->arg_passed_to_print_details !== "not specified")
                    $errors[] = "print_owing shoud not pass an argument to print_details";
                echo (count($errors) > 0)
                    ? json_encode($errors)
                    : 1;
            '
        );
    }
    
}