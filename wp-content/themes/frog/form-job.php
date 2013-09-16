<?php
/**
 * The template for displaying the job application form.
 *
 * @package Frog
 * @since Frog 1.0
 */
?>

	<aside class="entry-form">		
		<?php if (empty($_POST)) : ?>
			
			<form id="form-job" action="" method="post" enctype="multipart/form-data" class="validate">
				<input type="hidden" name="job_id" value="<?php the_slug(); ?>" />
			
				<section class="form-section">
					<h3>Personal Info</h3>

					<div class="input text first-name">
						<label for="first_name">First Name</label>
						<input type="text" name="first_name" maxlength="40" class="required" placeholder="first name" />
					</div>

					<div class="input text last-name">
						<label for="last_name">Last Name</label>
						<input type="text" name="last_name" maxlength="40" class="required" placeholder="last name" />
					</div>

					<div class="input text email">
						<label for="email">Email</label>
						<input type="email" name="email" maxlength="80" class="required email" placeholder="email" />
					</div>

					<div class="input text phone">
						<label for="phone">Phone</label>
						<input type="tel" name="phone" maxlength="15" class="phone" placeholder="phone" />
					</div>

					<div class="input textarea description">
						<label for="description">Please tell us why you want to be a part of this amazing team.</label>
						<textarea name="description" class="required" placeholder="Please tell us why you want to be a part of this amazing team."></textarea>
					</div>

					<div class="job-id"><span>job ID:</span> <?php the_slug(); ?><div>
				</section>
			
				<section class="form-section">
					<h3>Upload Your Resume</h3>
				
					<div class="input file resume">
						<label for="resume">Upload Your Resume</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="153600" />
						<input type="file" name="resume" accept="application/pdf,text/plain,application/msword" />
						<div class="note"><b>Files Allowed:</b> .txt, .doc, .docx, .pdf</div>
						<div class="note"><b>Max File Size:</b> 150 KB</div>
					</div>
				
					<div class="input textarea resume">
						<label for="resume_text">Or Just Use Plain Text</label>
						<textarea name="resume_text"></textarea>
					</div>
				</section>
			
				<div class="buttons cf">
					<a href="<?php echo home_url('/about/jobs/'); ?>" class="cancel button">Cancel</a>
					<button class="submit button" type="submit">Submit</button>
				</div>
			</form>
		
		<?php else : ?>
			
			<?php
				email_form_data('Frog: Job Application',
					array('job_id', 'first_name', 'last_name', 'email', 'phone', 'description', 'resume', 'resume_text')
				);
			?>
			<div class="message success">
				<h1>Thank You!</h1>
				<p>
					<?php
						$title = get_field('form_success');
						echo $title ? $title : 'Your form has successfully been submitted';
					?>
				</p>
			</div>
		
		<?php endif; ?>
	</aside>