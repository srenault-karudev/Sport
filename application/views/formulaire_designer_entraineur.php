<form action="" method="POST">
		<p>
			<label for="nom_entraineur">Nom</label>
				<br />
				<input type="text" name="nom_entraineur" value="<?php echo set_value('nom_entraineur'); ?>" id="nom_entraineur" />
				<br />

				<br />
				<input type="submit" value="Désigner comme entraineur" />					
		</p>
	</form>

	<p> <?php echo validation_errors(); ?> </p>