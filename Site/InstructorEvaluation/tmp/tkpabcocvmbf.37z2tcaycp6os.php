<div class="row-fluid col-lg-12 optionDiv">
	<div class='btn-group optionBtns center-block' name='<?php echo $question['questionID']; ?>_option'>
		<div class="text-center">
			<label class="radio-inline"><input type="radio" name='<?php echo $question['questionID']; ?>_option' value="1" <?php if ($question['inputAnswer'] == 1): ?> checked="checked" <?php endif ?>>Almost Always</input></label>
			<label class="radio-inline"><input type="radio" name='<?php echo $question['questionID']; ?>_option' value="2" <?php if ($question['inputAnswer'] == 2): ?> checked="checked" <?php endif ?> >Often</input></label>
			<label class="radio-inline"><input type="radio" name='<?php echo $question['questionID']; ?>_option' value="3" <?php if ($question['inputAnswer'] == 3): ?> checked="checked" <?php endif ?>>Sometimes</input></label>
			<label class="radio-inline"><input type="radio" name='<?php echo $question['questionID']; ?>_option' value="4" <?php if ($question['inputAnswer'] == 4): ?> checked="checked" <?php endif ?>>Rarely</input></label>
			<label class="radio-inline"><input type="radio" name='<?php echo $question['questionID']; ?>_option' value="5" <?php if ($question['inputAnswer'] == 5): ?> checked="checked" <?php endif ?> >Almost Never</input></label>
			<label class="radio-inline"><input type="radio" name='<?php echo $question['questionID']; ?>_option' value="6" <?php if ($question['inputAnswer'] == 6): ?> checked="checked" <?php endif ?> >N/A</input></label>
		</div>
	</div>
</div>