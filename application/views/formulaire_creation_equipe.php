	<form action="" method="POST" enctype="multipart/form-data">
		<p>
			<label for="nom_equipe">Nom</label>
				<br />
				<input type="text" name="nom_equipe" value="<?php echo set_value('nom_equipe'); ?>" id="nom_equipe" />
				<br />
			<label for="mot_de_passe_inscription">Mot de passe inscription</label>
				<br />
				<input type="text" name="mot_de_passe_inscription" value="<?php echo set_value('mot_de_passe_inscription'); ?>" id="mot_de_passe_inscription" />
				<br />
			<label for="sport">Sport</label>
				<br />
				<input type="text" name="sport" value="<?php echo set_value('sport'); ?>" id="sport" />
				<br /> <br />

			<input type="radio" name="mixite" value="0" id="non_mixte" checked="checked" /> <label for="non_mixte">Non mixte</label>

       		<input type="radio" name="mixite" value="1" id="mixte" /> <label for="mixte">Mixte</label>
       		<br /> <br />
			<label for="ville">Ville</label>
				<br />
				<input type="text" name="ville" value="<?php echo set_value('ville'); ?>" id="ville" />
				<br /> 
			<label for="description">Description</label>
				<br />
				<textarea rows="4" cols="50" name="description" id="description" placeholder="Décrivez votre équipe"><?php echo set_value('description'); ?></textarea>
				<br /> <br />

				<label for="logo">Logo</label>
				<input type="file" name="logo" id="logo" />

				<br /> <br />

				<label for="images">Image</label>
				<input type="file" name="image" id="image" />

				<br /> <br />
				<input type="submit" value="Créer" />					
		</p>
	</form>

	<p> <?php echo validation_errors(); ?> </p>
