<?php 
/**
* Project: IT Instructor Evaluations
* File: Options.php
* Authors: James Staab and Craig Koch 
* Date: 03/31/2016
* 
* This is an object for question options. This is to allow expandability if they want to have dynamic options
*/
class Options
{
	//For now we are using the following from a dropdown as answers for non-fill-in questions
	function printOptions($questionID, $selected)
	{
	?>
		<div class='col-md-4'>
			<select class='form-control' name='<?= $questionID; ?>_dropdown'>
				<option value="">Please Choose an Option</option>
				<option value="1" <?= $selected == 1 ?  "selected='selected'" : ''; ?> >Almost Always</option>
				<option value="2" <?= $selected == 2 ? "selected='selected'" : ''; ?> >Often</option>
				<option value="3" <?= $selected == 3 ? "selected='selected'": ''; ?> >Sometimes</option>
				<option value="4" <?= $selected == 4 ? "selected='selected'": ''; ?> >Rarely</option>
				<option value="5" <?= $selected == 5 ? "selected='selected'": ''; ?> >Almost Never</option>
			</select>
		</div>	
	<?php
	}
}

?>