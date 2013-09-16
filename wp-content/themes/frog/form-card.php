<?php
/**
 * The template for displaying the job application form.
 *
 * @package Frog
 * @since Frog 1.0
 */
?>
	
	<pre style="display:none;">
	<?php		
		$card = $error = $number = $pin = false;
		
		if (!empty($_POST['card_method'])) {
			$number = $_POST['card_number'];
			$pin = $_POST['card_pin'];
			
			$card = get_card_balance($number, $pin);
			if (!empty($card['error'])) {
				$error = $card['error'];
				$card = false;
			}
		}
	?>
	</pre>

	<section class="entry-form card-balance">	
			
		<?php if ($title = get_field('form_caption')) : ?>
			<p class="form-title"><?php echo $title; ?></p>
		<?php endif; ?>
		
		<form id="form-card-balance" action="" method="post" class="validate cf">
			<input type="hidden" name="card_method" value="balance" />
	
			<section class="form-section">
				<div class="input text card-number">
					<label for="card_number">Card Number</label>
					<input type="text" name="card_number" pattern="\d*" class="number required" placeholder="card number" value="<?php echo $number; ?>" />
				</div>

				<div class="input text card-pin">
					<label for="card_pin">PIN</label>
					<input type="text" name="card_pin" pattern="\d*" maxlength="10" class="number required" placeholder="pin" value="<?php echo $pin; ?>" />
				</div>
				
				<?php if ($image = get_field('help_image')) : ?>
					<span id="pin-help" class="help">?
						<div class="help-content">
							<?php $image = wp_get_attachment_image_src($image, 'side'); ?>
							<img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" />
							<span class="close"></span>
						</div>
					</span>
				<?php endif; ?>
			</section>
		
			<div class="buttons cf">
				<button class="submit button" type="submit">Submit</button>
			</div>
		</form>				
			
		<?php if ($card) : ?>
			<div class="balance">
				<p class="card">Card Number: <?php echo $card['id']; ?></p>
				<?php if ($card['status'] == 'ACTIVE') : ?>
					<p class="value">
						Balance: <?php echo $card['balance']; ?>
						<?php if ($card['points']) : ?>
						 / <?php echo $card['points']; ?> pts
						<?php endif; ?>
					</p>
				<?php else : ?>
					<p class="value closed">Balance: This card is <?php echo strtolower($card['status']); ?>.</p>
				<?php endif; ?>
			</div>
		<?php elseif ($error) : ?>
			<div class="error">The card number and/or pin you entered was not found.</div>
		<?php endif; ?>		
	</section>
	
	<section class="entry-form card-register">	
		
		<p class="form-title">Registration</p>
		
		<?php echo do_shortcode('[mc4wp-form]'); ?>
		
	</section>
	