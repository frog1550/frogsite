<?php
/**
 * The default template for displaying selectable forms.
 *
 * @package Frog
 * @since Frog 1.0
 */
?>

	<aside class="entry-form">
		<?php if ($title = get_field('form_caption')) : ?>
			<p class="form-title"><?php echo $title; ?></p>
		<?php endif; ?>
		
		<?php if (empty($_POST)) : ?>
			
			<form id="form-contact" action="" method="post" class="validate">
				<div class="input text name">
					<label for="full_name">Name</label>
					<input type="text" name="full_name" maxlength="80" class="required" placeholder="name" />
				</div>

				<div class="input text email">
					<label for="email">Email</label>
					<input type="email" name="email" maxlength="80" class="required email" placeholder="email" />
				</div>

				<div class="input text phone">
					<label for="phone">Phone</label>
					<input type="tel" name="phone" maxlength="15" class="phone" placeholder="phone" />
				</div>
			
				<div class="buttons cf">
					<button class="submit button" type="submit">Submit</button>
				</div>
			</form>
			
		<?php else : ?>
			
			<?php
				email_form_data('Frog: Contact',
					array('full_name', 'email', 'phone')
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