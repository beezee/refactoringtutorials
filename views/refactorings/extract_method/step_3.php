<?php $this->beginWidget('CMarkdown'); ?>

####Extract the outstanding calculation from Invoice::print_owing to Invoice::calculate_outstanding

This extraction will allow us to further clean up the class by removing the temporary $outstanding
variable altogether via Replace Temp with Query, eliminating the need for a parameter on
Invoice::print_details

*   Create an empty method called calculate_outstanding
*   Copy the code which sums up the $orders amounts from print_owing and
paste it in the new calculate_outstanding method (remove the comment, it is no longer needed thanks
to the method name)
*   Delete the original calculation code from the print_owing method,
including the unneeded comment
*   Move the initial definition of the $outstanding temporary variable from print_owing to
the beginning of calculate_outstanding, and be sure to return it at the end of the
calculate_outstanding method
*   Remove the $outstanding argument passed to print_details, and remove the $outstanding
argument accepted in the print_details signature
*   Replace the reference to the old $outstanding parameter in print_details with a call to
calculate_outstanding

<?php $this->endWidget(); 