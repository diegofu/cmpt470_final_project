<div id="do_ex_wrapper" class="row">
	<div class="span12 pagination-centered">
		<h3><?= $exercise->title ?></h3>
	</div>

	<div class="row span12">
		<div class="tabbable span5">
			<div class="accordion" id="accordion2">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">Instructions</a>
					</div>
					<div id="collapseOne" class="accordion-body collapse in">
						<div class="accordion-inner">
							<?= $this->text_format->text_to_html($exercise->instruction) ?>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">Expected Output</a>
					</div>
					<div id="collapseTwo" class="accordion-body collapse">
						<div class="accordion-inner">
							<div id="expected_output" class="tab-pane well" >
								<h4><?= $this->text_format->text_to_html($exercise->expected_output) ?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">Program Output</a>
					</div>
					<div id="collapseThree" class="accordion-body collapse">
						<div class="accordion-inner">
							<div id="run_results" class="tab-pane well"></div>
							<div id = "run_correctness" class = "label"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tabbable span6">
			<input type="hidden" name="solution" value="<?= htmlspecialchars($exercise->solution) ?>">
			<input type="hidden" name="template" value="<?= htmlspecialchars($exercise->template) ?>">
			<input type="hidden" name="language" value="<?= $exercise->get_plang()->name ?>">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#code_pane" data-toggle="tab">Code</a></li>
				<li><a href="#submission_pane" data-toggle="tab">Submissions</a></li>
				<li><a href="#solution_pane" data-toggle="tab">Solution</a></li>
			</ul>
			<div class="tab-content">
				<div id="code_pane" class="tab-pane active">
					<div id="code" class="span6"></div>
					<form method="post" action="<?= site_url('submissions/submit') ?>">
						<input type="hidden" value="<?= $exercise->id ?>" id="exercise_id" />
						<button id="run_code" class="btn span6" type="button" data-loading-text="Compiling and running code...">Run Code</button>
					</form> 
				</div>
				<div id="submission_pane" class="tab-pane">
					<div>
						<?
							foreach($exercise->get_submissions($this->tank_auth->get_user_id()) as $submission) {
						?>
						<div>
							<h6>
								<div class="accordion-heading">
							      <a class="accordion-toggle" data-toggle="collapse" href="#<?=$submission->id?>">
							        Attempted by <?= User::get_username_by_id($submission->author_id) ?> 
							        <span>
										<? if ($submission->correctness == 1)
												echo '<span class = "success">Correct</span>';
											else 
												echo '<span class = "error">Incorrect</span>';
										?> 
									</span>
									<span> when <?= $submission->created_time ?> </span>
							      </a>
							    </div>
							    <div id="<?=$submission->id?>" class="accordion-body collapse">
							      <div class="accordion-inner">
							        <?= nl2br(str_replace(' ','&nbsp;',$submission->body)) ?>
							      </div>
							    </div>
							<span></span>
							
							
							</h6>
						</div>
						<?
							}
						?>
					</div>
				</div>
				<div id="solution_pane" class="tab-pane">
					<div id="solutioncode" class="span6"></div>
				</div>
			</div>
		</div>
	</div>
</div>