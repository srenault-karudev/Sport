<form action="" method="POST">
		<p>
			<label for="nom_futur_membre">Nom</label>
				<br />
				<input type="text" name="nom_futur_membre" value="<?php echo set_value('nom_futur_membre'); ?>" id="nom_futur_membre" />
				<br />

				<br />
				<input type="submit" value="Inviter" />					
		</p>
	</form>

	<p> <?php echo validation_errors(); ?> </p>