<include href="views/EvaluationHeader.htm" with="info={{@headerInfo}}" />
<div class="col-md-12">
	{~ if(@alert): ~} 
	<div class="alert alert-{{@alertType}}" role="alert">
		{{@alert}}
	</div>
	{~ endif ~}
	<repeat group="{{@evaluation}}" key="{{@questionNumber}}" value="{{ @question}}">
		<div class="row form-group">
			{~ if(@question.error): ~} 
				<div class="alert alert-danger" role="alert">{{@question.error}}</div>
			{~ endif ~}
			<div class="row-fluid col-lg-12 questionText">
			<span><b>{{ (@questionNumber + 1)."." }}</b> {{ @question.questionText}}</span>
			</div>
			{~ if (@question.isFillIn) : ~}
				<include href="views/InputTemplate.htm" with="question={{@question}}" />
			{~ else: ~}
				<include href="views/OptionTemplate.php" with="question={{@question}}" />
			{~ endif ~}
		</div>
	</repeat>
	<div class="row-fluid col-lg-11">
	<input class="btn btn-primary btn-lg pull-right" name="submitEval" type="submit" value="Submit Evaluation"/>
	</div>
</div>

