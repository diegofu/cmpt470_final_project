<div>
	<? 
	if($this->session->flashdata('errors')) 
		echo $this->session->flashdata('errors');
	?>
	<div class="tabbable span12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#title-desc" data-toggle="tab">Title &amp; Description</a></li>
			<li class="disabled"><a href="#add-exec" data-toggle="tab">Add Exercises</a></li>
			<li class="disabled"><a href="#cart" data-toggle="tab">Cart</a></li>
		</ul>
		<div class="tab-content">
			<div id="title-desc" class="tab-pane active">
				<div class="span5">
					<div class="control-group">
						<label class="control-label" for="inputTitle">Title</label>
						<div class="controls">
							<input type="text" id="inputTitle" placeholder="Input title here" class="span4">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputDesc">Description</label>
						<div class="controls">
							<textarea rows="10" id="inputDesc" class="span4" placeholder="Input description here"></textarea>
						</div>
					</div>
				</div>
				<div class="container-box span6">
					<div class="header">What are collections?</div>
					<p>
						Collections are lists of exericses. 
						You can use collections to organize exercises so that it is easy for users to find.<br><br>
						Here are some examples of what you might use collections for:
					</p>	
					<ul>
						<li>Courses, ie, Introduction to Computer Science</li>
						<li>Sorting algorithms, ie, QuickSort, MergeSort, etc</li>
						<li>Problems you find interesting and want to sure a list with your friends</li>
					</ul>
				</div>
			</div>
			<div id="add-exec" class="tab-pane">
				<? $this->load->view('all_exercises'); ?>
			</div>
			<div id="cart" class="tab-pane">
				<div class="container-box span11">
					<h1></h1>
					<h3><small></small></h3>
					<div class="collection_exercises">
						<table class="table table-striped table-hover span10">
							<tr>
								<th>Exericse ID</th>
								<th>Title</th>
								<th>Author</th>
								<th>Views</th>
								<th>Votes</th>
								<th>Date Created</th>
								<th></th>
							</tr>
						</table>
						<div>&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pagination pagination-large pagination-centered">
			<ul>
				<li class="disabled"><a href="#" class="ue-back">Back</a></li>
				<li><a href="#" class="ue-next">Next</a></li>
			</ul>
		</div>
	</div>
</div>
