<form action="<?php  echo base_url(); ?>/Membre/connexion" method="POST">
	<p>
		<label for="nom_de_compte">Nom de compte</label>
			<br />
			<input type="text" name="nom_de_compte" value="<?php echo set_value('nom_de_compte'); ?>" id="nom_de_compte" />
			<br />
		<label for="mot_de_passe">Mot de passe</label>
			<br />
			<input type="password" name="mot_de_passe" id="mot_de_passe" />
			<br /> <br />

			<input type="submit" value="Connexion" />			
	</p>
</form>

<p> <?php echo validation_errors(); ?> </p>