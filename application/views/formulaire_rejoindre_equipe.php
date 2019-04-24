	<form action="<?php echo base_url(); ?>/Equipe/rejoindre_equipe" method="POST">
		<p>
			<label for="nom_equipe_a_rejoindre">Nom de l'équipe</label>
				<br />
				<input type="text" name="nom_equipe_a_rejoindre" value="<?php echo set_value('nom_equipe_a_rejoindre'); ?>" id="nom_equipe_a_rejoindre" />
				<br />
			<label for="mot_de_passe_equipe">Mot de passe </label>
				<br />
				<input type="text" name="mot_de_passe_equipe" value="<?php echo set_value('mot_de_passe_equipe'); ?>" id="mot_de_passe_equipe" />
				<br />

				<br />
				<input type="submit" value="Rejoindre" />					
		</p>
	</form>

	<p> <?php echo validation_errors(); ?> </p>