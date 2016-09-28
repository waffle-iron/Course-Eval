<div class="row-fluid col-lg-12 optionDiv">
	<div class='btn-group optionBtns center-block' name='{{@question.questionID}}_option'>
		<div class="text-center">
			<label class="radio-inline"><input type="radio" name='{{@question.questionID}}_option' value="1" {~ if (@question.inputAnswer == 1): ~} checked="checked" {~ endif~}>Almost Always</input></label>
			<label class="radio-inline"><input type="radio" name='{{@question.questionID}}_option' value="2" {~ if (@question.inputAnswer == 2): ~} checked="checked" {~ endif~} >Often</input></label>
			<label class="radio-inline"><input type="radio" name='{{@question.questionID}}_option' value="3" {~ if (@question.inputAnswer == 3): ~} checked="checked" {~ endif~}>Sometimes</input></label>
			<label class="radio-inline"><input type="radio" name='{{@question.questionID}}_option' value="4" {~ if (@question.inputAnswer == 4): ~} checked="checked" {~ endif~}>Rarely</input></label>
			<label class="radio-inline"><input type="radio" name='{{@question.questionID}}_option' value="5" {~ if (@question.inputAnswer == 5): ~} checked="checked" {~ endif~} >Almost Never</input></label>
			<label class="radio-inline"><input type="radio" name='{{@question.questionID}}_option' value="6" {~ if (@question.inputAnswer == 6): ~} checked="checked" {~ endif~} >N/A</input></label>
		</div>
	</div>
</div>