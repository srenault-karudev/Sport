<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="<?php  echo base_url();?>/css/accueil.css" />
		<title>Accueil - Gestion d'équipes sportives</title>
	</head>

	<body>

		<header>

			<h1>Gestion d'équipes sportives en ligne</h1>

			<nav>

			<ul>
    		    <li><a href="<?php echo base_url(); ?>">Accueil</a></li>
     		   <li><a href="<?php echo base_url(); ?>/Equipe/afficher_liste_equipes">Equipes</a></li>
      		  <li><a href="#">FAQ</a></li>
     		   <li><a href="#">Contact</a></li>
  		  </ul>

		</nav>

		</header>

		<div id="separation"></div>

		<?php

		if(!isset($_SESSION['id'])){


		?>

			<section class="section_gauche">

				<h2>Se connecter</h2>

				<?php

				echo $formulaire_connexion; 

				if(isset($informations_nom_de_compte)){

					echo $informations_nom_de_compte;
				}

				if(isset($informations_mot_de_passe)){

					echo $informations_mot_de_passe;
				}

				?>
			
			</section>

			<section class="section_droite">

				<h2>S'inscrire</h2>

				<?php

				echo $formulaire_inscription;

				?>

			</section>

		<?php

		}
		else{


		?>

			<section class="section_gauche">

				<h2><?php echo $login; ?></h2>

				<p id="avatar_utilisateur"> <img src="<?php echo base_url(); ?>/images/<?php echo $avatar; ?>" alt="avatar" height="225" width="225" /> </p>

				<p id="informations_utilisateur">
					Nom : <span class="information_utilisateur"><?php echo $nom; ?></span> <br />
					Prenom : <span class="information_utilisateur"><?php echo $prenom ?></span> <br /> 
					Email :  <span class="information_utilisateur"><?php echo $email ?></span> <br /> <br />

					<a href="<?php echo base_url(); ?>/Membre/modifier_profil/1">Modifier profil</a>
				</p>

				<p>
					<a href="<?php echo base_url(); ?>/Membre/deconnexion/1">Déconnexion</a> 
				</p>


			</section>

			<?php 

			// Si on veut créer une équipe
			if(isset($formulaire_creation_equipe)){

				?>

				<section class="section_droite">

					<h2>Création d'équipe</h2>

					<?php

					if(isset($au_moins_cinq_equipes)){

						echo "Vous êtes déjà dans 5 équipes.";
					}
					else{


						echo $formulaire_creation_equipe;

						if(isset($erreur_creation_equipe_logo)){

							?>

							<p><?php echo $erreur_creation_equipe_logo; ?></p>

							<?php
						}

						if(isset($erreur_creation_equipe_image)){

							?>

							<p><?php echo $erreur_creation_equipe_image; ?></p>

							<?php
						}

					}

					?>

				</section>

				<?php

			}

			// Si on veut la liste des équipes auxquelles on appartient
			else if(isset($liste_equipes)){

				?>

				<section class="section_droite">

					<h2>Mes équipes</h2>

					<p>

					<?php

					foreach($liste_equipes as $equipe){

						?>

						<a href="<?php echo base_url();?>/Equipe/afficher_informations_equipe/<?php echo $equipe['id_equipe']; ?>"><?php echo $equipe['nom']; ?></a> <br/>

						<?php
					}

					?>

				</p>

				</section>

				<?php
			}

			// Si on veut rejoindre une équipe
			else if(isset($liste_invitations_equipes)){

				?>

				<section class="section_droite">


					<h2> Liste invitations </h2>

					<p>

					<?php

					foreach($liste_invitations_equipes as $invitations){

						?>

						<a href="<?php echo base_url(); ?>/Equipe/rejoindre_equipe_via_invitation/<?php echo $invitations['id_equipe']; ?>"><?php echo $invitations['nom']; ?></a> <br/>

						<?php
					}

					?>

					</p>

					<h2>Rejoindre via code</h2>

					<?php 

					echo $formulaire_rejoindre_equipe; 

					if(isset($informations_rejoindre_equipe)){

						echo $informations_rejoindre_equipe . '<br />';
					}

					?>

				</section>

				<?php
			}

			// Si on est sur la page d'une équipe

			else if(isset($informations_equipe)){

				?>

				<section class="section_droite">

					<h2><?php echo $informations_equipe['nom']; ?></h2>

					<?php $mixite = ($informations_equipe['mixite'] == 0)?"Non mixte":"Mixte"; ?>

					<p id="images_equipe"> 
						<img src="<?php echo base_url(); ?>/images/<?php echo $informations_equipe['logo']; ?>" alt="logo" height="225" width="225" />
						<img src="<?php echo base_url(); ?>/images/<?php echo $informations_equipe['image']; ?>" alt="image" height="225" width="225" />  
					</p>

					<p>

						Sport : <?php echo $informations_equipe['sport']; ?> <br />
						Ville : <?php echo $informations_equipe['ville']; ?> <br />
						Description : <?php echo $informations_equipe['description']; ?> <br />
						Mixité : <?php echo $mixite; ?> <br />

					</p>

				</section>

				<?php

				if(isset($formulaire_designer_entraineur)){

					?>

					<section class="section_gauche">

						<h2 id="designer_entraineur">Désigner un entraineur</h2>
					<?php

						echo $formulaire_designer_entraineur;

					?>

					</section>

					<?php
				}
				else if(isset($formulaire_inviter_membre)){

					?>

					<section class="section_gauche">

						<h2 id="inviter_membre">Inviter un membre</h2>
						<?php

							echo $formulaire_inviter_membre;

							if(isset($deja_invite)){

								echo $deja_invite . '<br />';
							}

							if(isset($deja_dans_equipe)){

								echo $deja_dans_equipe . '<br />';
							}

							if(isset($utilisateur_invite_existe_pas)){

								echo $utilisateur_invite_existe_pas . '<br />';
							}

						?>

					</section>

					<?php
				}
				else if(isset($formulaire_creation_evenement)){

					?>

					<section class="section_gauche">

						<h2 id="creer_evenement">Créer un evenement</h2>
					<?php

						echo $formulaire_creation_evenement;

					?>

					</section>

					<?php
				}

				else if(isset($menu_equipe)){

					echo $menu_equipe;
				}

				// Si on veut consulter un evenement précis
				if(isset($informations_evenement)){

					?>

					<section class="section_droite">

						<h2 id="evenements"><?php echo $informations_evenement['type']; ?> du <?php echo $informations_evenement['debut']; ?></h2>

						<p>

							Début : <?php echo $informations_evenement['debut']; ?> <br />
							Fin : <?php echo $informations_evenement['fin']; ?> <br />
							Lieu : <?php echo $informations_evenement['lieu']; ?> <br />
							Description : <?php echo $informations_evenement['description']; ?> <br />
							<a href="<?php echo base_url(); ?>/Evenement/liste_participants_evenement/<?php echo $informations_evenement['id']; ?>#evenements">Liste des participants</a> <br />
						</p>

					</section>

				<?php

				}
				else if(isset($liste_participants_evenement)){

					?>

					<section class="section_droite">

						<h2 id="evenements">Participants</h2>

						<p>

							<?php

							$participer = 1;

							foreach($liste_participants_evenement as $informations_participants){

								echo $informations_participants['login'];

								if($informations_participants['login'] == $_SESSION['login']){

									$participer = 0;
								}
							?>

							<br/>

							<?php

							}

							if($participer == 1){

								?>

								<a href="<?php echo base_url(); ?>/Evenement/participer_evenement/<?php echo $id_evenement; ?>">Participer</a> <br />

								<?php
							}

						?>

						</p>

					</section>

					<?php
				}
				else{

				?>

					<section class="section_droite">

						<h2 id="evenements">Evenements</h2>

						<p>

							<?php

							foreach($informations_evenements_equipe as $informations){

							?>

							<a href="<?php echo base_url(); ?>/Evenement/consulter_evenement/<?php echo $informations['id']; ?>#evenements"><?php echo $informations['type']; ?> du <?php echo $informations['debut']; ?></a> <br/>

							<?php

						}

						?>

						</p>

					</section>

				<?php

				}
			}

			// Si on est connecté

			else{

				?>

				<section class="section_droite">

					<h2>Menu principal</h2>

					<p>

						<a href="<?php echo base_url();?>/Equipe/creer_equipe/1">Créer une équipe</a> <br />	
						<a href="<?php echo base_url();?>/Equipe/afficher_liste_equipes">Mes Equipes : <?php echo $nombre_equipes; ?></a>	<br />
						<a href="<?php echo base_url();?>/Equipe/rejoindre_equipe">Rejoindre équipe</a>	<br />
						<a href="">Modifier profil</a>
					</p>

				</section>

		<?php

			}

		}

		?>

		<!--

		<footer>

			<p> Site réalisé par Steven Renault et Philemon Christopher</p>

		</footer>

		-->

	</body>

</html>