<?php $this->beginWidget('CMarkdown'); ?>

####Extract the details output from Invoice::print_owing to Invoice::print_details

This extraction requires an additional step. Because there is a locally scoped variable
$outstanding which is needed in outputting the details, we need to accept an argument in
the new method and pass it when it is called from print_owing.

*   Create an empty method called print_details
*   Copy the code which outputs the details from the print_owing method and paste it
into the new print_details method (remove the comment, it is no longer needed thanks
to the method name)
*   Adjust the print_details method signature to accept one argument named $outstanding
*   Delete the original detail output code from the print_owing method,
including the unneeded comment
*   Call the print_details method from print_owing, in the same place where the banner code
used to be
*   Pass the $outstanding variable into the new call to print_details from print_owing

<?php $this->endWidget(); 