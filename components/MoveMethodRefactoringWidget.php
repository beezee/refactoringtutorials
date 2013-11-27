<?php

class MoveMethodRefactoringWidget extends PHPRefactoringWidget
{
    public $title = 'Move Method';
    public $viewPath = '//refactorings/move_method/';
    public $startingCode = '    
<?php

	class Account
	{
		
		private $_account_type;
		public $days_overdrawn = 9;

		public function __construct(AccountType $account_type)
		{
			$this->_account_type = $account_type;
		}

		public function overdraft_charge()
		{
			$amount = 0;
			if ($this->_account_type->is_premium())
			{
				$amount += 10;
				if ($this->days_overdrawn > 7)
					$amount += ($this->days_overdrawn - 7) * .85;
			} else
				$amount = $this->days_overdrawn * 1.75;
			return $amount;
		}
				
		public function bank_charge()
		{
			$amount = 4.5;
			if ($this->days_overdrawn > 0)
				$amount += $this->overdraft_charge();
			return $amount;
		}
	}

	class AccountType
	{
		
		private $_premium;

		public function __construct($premium)
		{
			$this->_premium = $premium;
		}

		public function is_premium()
		{
			return $this->_premium;
		}
	}
';

	public function getStepValidationAssertions()
	{
		return array(
			1 => '
				class TestAccountType extends AccountType
				{
					public $days_overdrawn = 4;

					public function __get($name)
					{
						if ($name === "account_type")
							return $this;
						return parent::__get($name);
					}
				}

				$t = new TestAccountType(true);
				if (!method_exists($t, "overdraft_charge"))
				{
				 	echo json_encode(array("AccountType class should have an overdraft_charge method"));
					exit;
				}
				if (!is_callable(array($t, "overdraft_charge")))
				{
					echo json_encode(array("AccountType::overdraft_charge should have public visibility"));
					exit;
				}
				$first_check = ($t->overdraft_charge() === 10);
				$t->days_overdrawn = 8;
				$second_check = ($t->overdraft_charge() === 10.85);
				$t = new TestAccountType(false);
				$t->days_overdrawn = 8;
				$third_check = ($t->overdraft_charge() === (8 * 1.75));
				echo ($first_check and $second_check and $third_check)
					? 1
					: json_encode(array("AccountType::overdraft_charge should contain the same code as Account::overdraft_charge"))
				',
			2 => '
				class TestAccountType extends AccountType
				{
					public function __get($name)
					{
					 	echo json_encode(array("$name is not a property of AccountType"));
						exit;	
					}
				}
				$t = new TestAccountType(true);
				$rt = new ReflectionClass($t);
				$rm = $rt->getMethod("overdraft_charge");
				if (!(count($params = $rm->getParameters()) == 1 and $params[0]->name === "days_overdrawn"))
				{
					echo json_encode(array("AccountType::overdraft_charge should accept one argument called \$days_overdrawn"));
					exit;
				}
				$first_check = ($t->overdraft_charge(4) === 10);
				$second_check = ($t->overdraft_charge(8) === 10.85);
				$t = new TestAccountType(false);
				$third_check = ($t->overdraft_charge(8) === (8 * 1.75));
				echo ($first_check and $second_check and $third_check)
					? 1
					: json_encode(array("AccountType::overdraft_charge should use the $days_overdrawn argument to perform all calculations"));
				',
			3 => '
				class TestAccountType extends AccountType
				{
					public $called_overdraft_charge = false;

					public function overdraft_charge($days_overdrawn=-30)
					{
						$this->called_overdraft_charge = true;
						return parent::overdraft_charge($days_overdrawn);
					}

					public function __get($name)
					{
					 	echo json_encode(array("$name is not a property of AccountType"));
						exit;	
					}
				}

				class TestAccount extends Account
				{
					public function __get($name)
					{
					 	echo json_encode(array("$name is not a property of Account"));
						exit;	
					}
				}
				$at = new TestAccountType(true);
				$t = new TestAccount($at);
				$t->days_overdrawn = 4;
				$first_check = ($t->overdraft_charge() === 10);
				$t->days_overdrawn = 8;
				$second_check = ($t->overdraft_charge() === 10.85);
				$at = new TestAccountType(false);
				$t = new Account($at);
				$t->days_overdrawn = 8;
				$third_check = ($t->overdraft_charge() === (8 * 1.75));
				$errors = array();
				if (!$at->called_overdraft_charge)
					$errors[] = "Account::overdraft_charge should call AccountType::overdraft_charge";
				if (!($first_check and $second_check and $third_check))
					$errors[] = "AccountType::overdraft_charge should use the \$days_overdrawn argument to perform all calculations";
				echo (count($errors) > 0)
					? json_encode($errors)
					: 1;
				'
		);
	}
}
