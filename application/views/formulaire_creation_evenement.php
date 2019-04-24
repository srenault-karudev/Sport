	<form action="" method="POST">
		<p>
			Type <br /> <br />
			<input type="radio" name="type" value="entrainement" id="entrainement" /> <label for="entrainement">Entrainement</label>

       		<input type="radio" name="type" value="match" id="match" /> <label for="match">Match</label>

      		 <input type="radio" name="type" value="competition" id="competition" /> <label for="competition">Competition</label><br />
				<br />
			<label for="debut">Début</label>
				<br />
				<input type="date" name="debut" value="<?php echo set_value('debut'); ?>" id="debut" />
				<br />
			<label for="fin">Fin</label>
				<br />
				<input type="date" name="fin" value="<?php echo set_value('fin'); ?>" id="fin" />
				<br /> 
			<label for="lieu">Lieu</label>
				<br />
				<input type="text" name="lieu" value="<?php echo set_value('lieu'); ?>" id="lieu" />
				<br /> 
			<label for="description">Description</label>
				<br />
				<textarea rows="4" cols="50" name="description" id="description" placeholder="Décrivez votre équipe"><?php echo set_value('description'); ?></textarea>
				<br /> 

				<br />
				<input type="submit" value="Créer" />					
		</p>
	</form>

	<p> <?php echo validation_errors(); ?> </p>