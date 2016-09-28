<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12 text-center">
			<h1>Generate a test with default questions</h1>
		</div>
	</div>
	
	<div class="container-fluid">
		{~ if(@message.alert): ~} 
		<div class="alert alert-{{@message.alertType}}" role="alert">
			{~ if(!is_array(@message.alert)): ~}
				{{@message.alert}}
			{~ else: ~}
			<ul>
			<repeat group="{{@message.alert}}" value="{{@error}}">
				<li>{{@error}}</li>
			</repeat>
			</ul>
			{~ endif ~}
		</div>
		{~ endif ~}
		<div class="row-fluid col-lg-12">
			<h2>Course Information</h2>
			<div class='col-md-6'>
				<input type="text" name="className" placeholder="Class Name" class="form-control"  value="{{@info.className}}">
			</div>

			<div class='col-md-2'>
				<select class='form-control' name="year">
					<option value="">Year</option>
					<option value="20152016" {~ if(@info.year == "20152016") : ~} selected {~endif~}>2015-2016</option>
					<option value="20162017"{~ if(@info.year == "20162017") : ~}selected {~endif~}>2016-2017</option>
					<option value="20172018"{~ if(@info.year == "20172018") : ~}selected {~endif~}>2017-2018</option>
					<option value="20182019"{~ if(@info.year == "20182019"): ~}selected {~endif~}>2018-2019</option>
					<option value="20192020"{~ if(@info.year == "20192020"): ~}selected {~endif~}>2018-2019</option>
				</select>		
			</div>
						
			<div class='col-md-4'>
				<select class='form-control' name="quarter" value="{{@info.quarter}}">
					<option value="">Quarter</option>
					<option value="1"{~if(@info.quarter == 1):~}selected {~endif~}>Fall</option>
					<option value="2"{~if(@info.quarter == 2):~}selected {~endif~}>Winter</option>
					<option value="3"{~if(@info.quarter == 3):~}selected {~endif~}>Spring</option>
					<option value="4"{~if(@info.quarter == 4):~}selected {~endif~}>Summer</option>
				</select>
			</div>
		
			<div class='col-md-6 col-md-offset-6'>
				<span>Section Number:</span>
				<input type="text" name="section" placeholder="Section Number" class="form-control"  value="{{@info.section}}">
			</div>		
		</div>
		
		<div class="row-fluid col-lg-12">
			<h2>Options:</h2>
				<div class="col-md-2">
					<span>Expiration Date:</span>
					<input type="date" name="endDate" class="form-control" placeholder="2016-03-14" value="{{@info.expirationDate}}">
				</div>
					
		
			<div class="col-md-6">
				<span>Notes:</span>
				<textarea rows="4" cols="50" class="form-control" placeholder="Notes about this test" name="notes">{{@info.notes}}</textarea>
			</div>
		</div>
	
	</div>

	<div class="container-fluid pull-right">
			<input type="submit" value="Get Entry Code" class="btn btn-primary btn-lg">	
		</div>

		<!-- Generate Code Section -->
			<div class="row-fluid">
				<repeat group="{{ @div }}" key="{{ @ikey }}" value="{{ @idiv }}">
				{~ if(@previousEntry[0]): ~}
				<div class="panel panel-default coll-md-8">
				  <div class="panel-heading">Your last entry</div>
					  <div class="panel-body">
					  	<div><b>Entry Code:<a href="{{@siteAddress.'/Evaluation/'. @previousEntry[1]}}">{{@siteAddress.'/Evaluation/'. @previousEntry[1]}}</a></b></div>
						<div>Evaluation ID:{{@previousEntry[0]}}</div>
						<div>Class Name:{{@previousEntry[2]}}</div>
						<div>Quarter:{{@previousEntry[3]}}</div>
						<div>Year:{{@previousEntry[4]}}</div>
						<div>Section Number:{{@previousEntry[5]}}</div>
						<div>Notes:{{@previousEntry[6]}}</div>
						<div>Expiration Date:{{@previousEntry[7]}}</div>
						<div>Number of Test Available:{{@previousEntry[8]}}</div>
					</div>
				</div>
				{~ endif ~}
			</div>
			<!-- END of Generated Code Section -->
</div>

