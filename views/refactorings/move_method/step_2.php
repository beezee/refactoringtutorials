<?php $this->beginWidget('CMarkdown'); ?>

####Update the AccountType::overdraft_charge method so that it is aware of its new context
*	$this->account_type should become just $this
*	$this->days_overdrawn should be replaced with a passed argument, $days_overdrawn. If there were more attributes required from the Account object you might consider passing the entire instance as an argument.

<?php $this->endWidget(); ?>


