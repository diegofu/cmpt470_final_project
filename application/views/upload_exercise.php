<div>
	<? 
	if($this->session->flashdata('errors')) 
		echo $this->session->flashdata('errors');
	?>
	<div class="tabbable span11">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#title-tags" data-toggle="tab">Title &amp; Tags</a></li>
			<li class="disabled"><a href="#sol-temp" data-toggle="tab">Solution and template</a></li>
			<li class="disabled"><a href="#expected-output" data-toggle="tab">Output from your solution</a></li>
			<li class="disabled"><a href="#review-submit" data-toggle="tab">Review &amp; Submit</a></li>
		</ul>
		<form id="upload_exercise_form" action="<?= site_url('/exercises/submit')?>" method="post">
			<div class="tab-content">
				<div id="title-tags" class="tab-pane active">
					<div class="span4">
						<ul class="nav nav-tabs">
							<li class="active">
							    <a href="#" rel="tooltip" title="The below field should contain the title to your exercise">Exercise Title</a>
							</li>
						</ul>
						<div class="input-prepend">
							<input type="text" class="required span4" name="title" >
						</div>
						
						<ul class="nav nav-tabs">
							<li class="active">
							    <a href="#" rel="tooltip" title="Add tags by typing below, suggestions will show up. Press enter to confirm a tag add.">Add Tags</a>
							</li>
						</ul>
						<div class="controls line">
							<ul id="tags"></ul>
						</div>

						<ul class="nav nav-tabs">
							<li class="active">
							    <a href="#" rel="tooltip" title="Select the programming language for your exercise.">Select Programming Language</a>
							</li>
						</ul>
						<?= form_dropdown('language', $language, 'default', 'class="span4"'); ?>
					</div>

					<div class="span6">
						<ul class="nav nav-tabs">
							<li class="active">
							    <a href="#instructions" rel="tooltip" title="Describe how your exercise should be completed. Don't worry about the exact output, your program will be compiled to generate that.">Instructions</a>
							</li>
						</ul>
						<div id="instructions" class="tab-pane active">
						</div>
					</div>
				</div>
				<div id="sol-temp" class="tab-pane">
					<div class="span5">
						<ul class="nav nav-tabs">
							<li class="active">
							    <a href="#" rel="tooltip" title="The source code will be used to generate the expected output and provide validation for the user">Exercise Source Code</a>
							</li>
						</ul>
						<div id="solution" class="span5">
						</div>					
					</div>
					<div class="span5">
						<ul class="nav nav-tabs">
							<li class="active">
							    <a href="#" rel="tooltip" title="Users will be provided this as a starting point to complete your exercise">Source Code Template for Users</a>
							</li>
						</ul>
						<div id="template" class="span5">
						</div>						
					</div>
				</div>
				<div id="expected-output" class="tab-pane" >
					<div class="hero-unit">
					</div>
				</div>
				<div id="review-submit" class="tab-pane">
					<div class="hero-unit">
					</div>
				</div>
			</div>
			<div class="pagination pagination-large pagination-centered">
				<ul>
					<li class="disabled"><a href="#" class="ue-back">Back</a></li>
					<li><a href="#" class="ue-next">Next</a></li>
				</ul>
			</div>
			<input type="hidden" name="instruction" value="">
			<input type="hidden" name="solution" value="">
			<input type="hidden" name="template" value="">
		</form>
	</div>
</div>
