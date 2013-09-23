<?php $this->beginWidget('CMarkdown'); ?>

####Extract the banner code from Invoice::print_owing to Invoice::print_banner

*   Create an empty method called print_banner
*   Copy the code which outputs the banner from the print_owing method and paste it
into the new print_banner method (leave the comment, it is no longer needed thanks
to the method name)
*   Delete the original banner code from the print_owing method, including the unneeded comment
*   Call the print_banner method from print_owing, in the same place where the banner code
used to be

<?php $this->endWidget(); 