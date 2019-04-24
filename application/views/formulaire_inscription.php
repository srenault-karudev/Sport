	<form action="<?php echo base_url(); ?>/Membre/inscription" method="POST">
		<p>
			<label for="nom_inscription">Nom</label>
				<br />
				<input type="text" name="nom_inscription" value="<?php echo set_value('nom_inscription'); ?>" id="nom_inscription" />
				<br />
			<label for="prenom_inscription">Prénom</label>
				<br />
				<input type="text" name="prenom_inscription" value="<?php echo set_value('prenom_inscription'); ?>" id="prenom_inscription" />
				<br />
			<label for="nom_de_compte_inscription">Nom de compte</label>
				<br />
				<input type="text" name="nom_de_compte_inscription" value="<?php echo set_value('nom_de_compte_inscription'); ?>" id="nom_de_compte_inscription" />
				<br />
			<label for="mot_de_passe_inscription">Mot de passe</label>
				<br />
				<input type="password" name="mot_de_passe_inscription" value="<?php echo set_value('mot_de_passe_inscription'); ?>" id="mot_de_passe_inscription" />
				<br />
			<label for="confirmation_mot_de_passe_inscription">Confirmation</label>
				<br />
				<input type="password" name="confirmation_mot_de_passe_inscription" value="<?php echo set_value('confirmation_mot_de_passe_inscription'); ?>" id="confirmation_mot_de_passe_inscription" />
					<br />
			<label for="email_inscription">Email</label>
				<br />
				<input type="mail" name="email_inscription" value="<?php echo set_value('email_inscription'); ?>" id="email_inscription" />
				<br /> <br />
				<input type="submit" value="S'inscrire" />					
		</p>
	</form>

	<p> <?php echo validation_errors(); ?> </p>