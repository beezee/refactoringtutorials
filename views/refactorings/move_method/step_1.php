<?php $this->beginWidget('CMarkdown'); ?>

####Move the overdraft_charge method from the Account class to the AccountType class

Since the overdraft_charge method returns a result based largely on information that comes from the AccountType class, it will be more at home there.

*	Define the overdraft_charge method in the AccountType class and copy the code from the implementation on the Account class	

<?php $this->endWidget(); ?>

