
<?php

session_start();

defined('BASEPATH') OR exit('No direct script access allowed');

class Equipe extends CI_Controller {

	public function __construt(){

		parent::__construct();
	}

public function afficher_informations_equipe($id_equipe, $afficher=1){

	$_SESSION['derniere_equipe_memorisee'] = $id_equipe;

	// on charge les differents models pour faire appel aux fonctions

	$this->load->model('model_equipe');
	$this->load->model('model_evenement');
	$this->load->model('model_membre');

		// On recharge les informations de l'utilisateur

		$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		$data['informations_equipe'] = $this->model_equipe->get_informations_equipe($id_equipe);

		$data['informations_evenements_equipe'] = $this->model_evenement->get_liste_evenements($data['informations_equipe']['id']);

		$rang_dans_equipe = $this->model_equipe->get_rang_equipe($id_equipe);

		switch ($rang_dans_equipe) {
			case 0:
				
				$data['menu_equipe'] = $this->load->view('menu_administrateur_equipe', NULL, TRUE);
				break;

			case 1:
				$data['menu_equipe'] = $this->load->view('menu_entraineur_equipe', NULL, TRUE);
				break;
			
			default:
				$data['menu_equipe'] = $this->load->view('menu_membre_equipe', NULL, TRUE);
				break;
		}
		if($afficher ==  1){
			$this->load->view('accueil', $data);
		}
		else{
			return $data;
		}

		

}


	public function creer_equipe($id_equipe){

		// Si on n'est pas connecté on est redirigé à l'accueil
		if(!isset($_SESSION['id'])){

			redirect(base_url());
		}

		$this->load->model('model_equipe');
		$this->load->model('model_membre');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');


		// On on n'est pas encore dans 5 équipes 
		if($this->model_equipe->get_nombre_equipes_actuel() < 5){


			// Si on a déja remplit le formulaire pour créer une équipe
			if(isset($_POST['nom_equipe'])){

				$config['upload_path']          = './images/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 2048;
                $config['max_width']            = 300;
                $config['max_height']           = 300;

                $this->load->library('upload', $config);

				// règles des champs du formulaire de création d'équipe
				$this->form_validation->set_rules('nom_equipe', 'Nom_equipe', 'required|min_length[2]|max_length[20]|is_unique[equipeP.nom]', array('required' => 'Le nom est vide.', 'min_length' => 'Le nom doit faire au moins 2 caractères.', 'max_length' => 'Le nom ne doit pas dépasser 20 caractères.', 'is_unique' => 'Nom déjà utilisé.'));
				$this->form_validation->set_rules('mot_de_passe_inscription', 'Mot_de_passe_inscription_inscription', 'required|min_length[2]|max_length[20]', array('required' => 'Le mot de passe est vide.', 'min_length' => 'Le mot de passe doit faire au moins 2 caractères.', 'max_length' => 'Le mot de passe ne doit pas dépasser 20 caractères.'));
				$this->form_validation->set_rules('sport', 'Sport', 'required|min_length[2]|max_length[20]', array('required' => 'Le sport est vide.', 'min_length' => 'Le sport doit faire au moins 2 caractères.', 'max_length' => 'Le sport ne doit pas dépasser 20 caractères.'));
				$this->form_validation->set_rules('ville', 'Ville', 'required|min_length[2]|max_length[20]', array('required' => 'La ville est vide.', 'min_length' => 'La ville doit faire au moins 2 caractères.', 'max_length' => 'La ville ne doit pas dépasser 20 caractères.'));
				$this->form_validation->set_rules('description', 'Description', 'required|min_length[2]', array('required' => 'La description est vide.', 'min_length' => 'La description doit faire au moins 2 caractères.'));
				$this->form_validation->set_rules('mixite', 'Mixite', 'required', array('required' => 'Veuillez renseigner la mixité.'));
				// Si le formulaire comporte des erreurs
				if (($this->form_validation->run() == FALSE) || ($this->upload->do_upload('logo') == FALSE)){

					// On recharge les informations de l'utilisateur
					$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		     		// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		      		$data['formulaire_creation_equipe'] = $this->load->view('formulaire_creation_equipe', NULL, TRUE);

		      		if($this->upload->do_upload('logo') == FALSE){

		      			$data['erreur_creation_equipe_logo'] = "Logo invalide ( png/jpg en 300*300 maximum )";
		      		} 

		           	$this->load->view('accueil', $data);
		        }

		      	// Si tout a été templi correctement
		      	else{


		      		$infos_logo = $this->upload->data();

                    $logo = $infos_logo['file_name'];


                    $config['upload_path']          = './images/';
	                $config['allowed_types']        = 'jpg|png';
	                $config['max_size']             = 2048;
	                $config['max_width']            = 300;
	                $config['max_height']           = 300;

	                $this->load->library('upload', $config);

	                if($this->upload->do_upload('image') == FALSE){

	                	// On recharge les informations de l'utilisateur
						$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

			     		// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
			      		$data['formulaire_creation_equipe'] = $this->load->view('formulaire_creation_equipe', NULL, TRUE);

			      		$data['erreur_creation_equipe_image'] = "Image invalide ( png/jpg en 300*300 maximum )";

			           	$this->load->view('accueil', $data);
	                }
	                else{

	                	$infos_image = $this->upload->data();

                   		$image = $infos_image['file_name'];

	                	$this->model_equipe->ajouter_equipe($_POST['nom_equipe'], $_POST['mot_de_passe_inscription'], $_POST['sport'], $_POST['ville'], $_POST['description'], $_POST['mixite'], $logo, $image);
				
						// On recharge les informations de l'utilisateur
						$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

						$this->load->view('accueil', $data);
	                }
		  
		      	}
			}
			else{

				// On recharge les informations de l'utilisateur
				$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

				// On crée une variable $formulaire_creation_equipe qui sera transmise à la vue et indiquera qu'il faut afficher le formulaire de création d'équipe
				$data['formulaire_creation_equipe'] = $this->load->view('formulaire_creation_equipe', NULL, TRUE);

				// On charge la vue
				$this->load->view('accueil', $data);
			}
		}

		// On recharge la page sans modification
		else{

			$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

			$data['au_moins_cinq_equipes'] = true;

			$data['formulaire_creation_equipe'] = $this->load->view('formulaire_creation_equipe', NULL, TRUE);

			$this->load->view('accueil', $data);
		}
	}


	public function afficher_liste_equipes(){

		$this->load->model('model_equipe');
		$this->load->model('model_membre');

		// On recharge les informations de l'utilisateur
		$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		$data['liste_equipes'] = $this->model_equipe->get_liste_equipes();

		$this->load->view('accueil', $data);

	}

	public function rejoindre_equipe_via_invitation($id_equipe){

		$this->load->model('model_equipe');
		$this->load->model('model_membre');

		$this->model_equipe->rejoindre_equipe($id_equipe);

		// On recharge les informations de l'utilisateur
		$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		$this->load->view('accueil', $data);
	}


	public function rejoindre_equipe(){

		$this->load->model('model_equipe');
		$this->load->model('model_membre');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');	

		// On recharge les informations de l'utilisateur
		$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		// On récupère la liste des équipes qui nous ont invité
		$data['liste_invitations_equipes'] = $this->model_equipe->get_liste_invitations_equipes();

		// Si on a essayé de rejoindre une équipe via son mot de passe
		if(isset($_POST['nom_equipe_a_rejoindre'])){

			// règles des champs du formulaire pour rejoindre une équipe
				$this->form_validation->set_rules('nom_equipe_a_rejoindre', 'Nom_equipe_a_rejoindre', 'required|min_length[2]|max_length[20]', array('required' => 'Le nom est vide.', 'min_length' => 'Le nom doit faire au moins 2 caractères.', 'max_length' => 'Le nom ne doit pas dépasser 20 caractères.'));
				$this->form_validation->set_rules('mot_de_passe_equipe', 'Mot_de_passe_equipe', 'required|min_length[2]|max_length[20]', array('required' => 'Le mot de passe est vide.', 'min_length' => 'Le mot de passe doit faire au moins 2 caractères.', 'max_length' => 'Le mot de passe ne doit pas dépasser 20 caractères.'));

				// Si le formulaire comporte des erreurs
				if ($this->form_validation->run() == FALSE){

		     		// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		      		$data['formulaire_rejoindre_equipe'] = $this->load->view('formulaire_rejoindre_equipe', NULL, TRUE);
		           	$this->load->view('accueil', $data);
		        }
		        else{

		        	$id_equipe = $this->model_equipe->get_id_equipe($_POST['nom_equipe_a_rejoindre']);

		        	if($id_equipe != 0){

			        	if($this->model_equipe->verifier_appartenance_equipe($id_equipe) == 0){

			        		if($this->model_equipe->get_nombre_equipes_actuel() < 5){

				        		$rejoindre = $this->model_equipe->rejoindre_equipe_via_mot_de_passe($_POST['nom_equipe_a_rejoindre'], $_POST['mot_de_passe_equipe']);

						        if($rejoindre == 1){

						        	$this->afficher_liste_equipes();
						        }
						        else{

						        	$data['informations_rejoindre_equipe'] = "Mot de passe incorrect.";

						    		// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
				      				$data['formulaire_rejoindre_equipe'] = $this->load->view('formulaire_rejoindre_equipe', NULL, TRUE);
				           			$this->load->view('accueil', $data);
						        }
			        		}
							else{

								$data['informations_rejoindre_equipe'] = "Vous avez déjà 5 équipes !";

								// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
							    $data['formulaire_rejoindre_equipe'] = $this->load->view('formulaire_rejoindre_equipe', NULL, TRUE);
							    $this->load->view('accueil', $data);
							}
			        
					    }
					    else{

					    	$data['informations_rejoindre_equipe'] = "Vous êtes déjà dans cette équipe.";

					    	// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
			      			$data['formulaire_rejoindre_equipe'] = $this->load->view('formulaire_rejoindre_equipe', NULL, TRUE);
			           		$this->load->view('accueil', $data);
					    }
					}
					else
					{
						$data['informations_rejoindre_equipe'] = "Cette équipe n'éxiste pas.";

					    // On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
			      		$data['formulaire_rejoindre_equipe'] = $this->load->view('formulaire_rejoindre_equipe', NULL, TRUE);
			           	$this->load->view('accueil', $data);
					}
		        }

		}
		else{

			// On charge le formulaire pour rejoindre une équipe
			$data['formulaire_rejoindre_equipe'] = $this->load->view('formulaire_rejoindre_equipe', NULL, TRUE);

			$this->load->view('accueil', $data);

		}
	}
	public function designer_entraineur($id_equipe){

		$this->load->model('model_equipe');
		$this->load->model('model_membre');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');	


		// On recharge les informations de l'utilisateur
		$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		$data = $data + $this->afficher_informations_equipe($id_equipe, 0);

		// Si on a essayé de désigner un entraineur
		if(isset($_POST['nom_entraineur'])){

			$this->form_validation->set_rules('nom_entraineur', 'Nom_entraineur', 'required|min_length[2]|max_length[20]', array('required' => 'Le nom est vide.', 'min_length' => 'Le nom doit faire au moins 2 caractères.', 'max_length' => 'Le nom ne doit pas dépasser 20 caractères.'));
		
			// Si le formulaire comporte des erreurs
			if ($this->form_validation->run() == FALSE){

		     	// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		   		$data['formulaire_designer_entraineur'] = $this->load->view('formulaire_designer_entraineur', NULL, TRUE);
	         	$this->load->view('accueil', $data);

		    }
		    else{

		    	$this->model_equipe->ajouter_entraineur($_POST['nom_entraineur'], $data['informations_equipe']['id']);

		    	$this->load->view('accueil', $data);
		    }
		}
		else{

			// On charge le formulaire pour désigner un entraineur
			$data['formulaire_designer_entraineur'] = $this->load->view('formulaire_designer_entraineur', NULL, TRUE);

			$this->load->view('accueil', $data);
		}

	}


	public function inviter_membre($id_equipe){

		$this->load->model('model_equipe');
		$this->load->model('model_membre');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');	


		// On recharge les informations de l'utilisateur
		$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		$data = $data + $this->afficher_informations_equipe($id_equipe,0);

		// Si on a essayé d'inviter un membre'
		if(isset($_POST['nom_futur_membre'])){

			$this->form_validation->set_rules('nom_futur_membre', 'Nom_futur_membre', 'required|min_length[2]|max_length[20]', array('required' => 'Le nom est vide.', 'min_length' => 'Le nom doit faire au moins 2 caractères.', 'max_length' => 'Le nom ne doit pas dépasser 20 caractères.'));
		
			// Si le formulaire comporte des erreurs
			if ($this->form_validation->run() == FALSE){

		     	// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		   		$data['formulaire_inviter_membre'] = $this->load->view('formulaire_inviter_membre', NULL, TRUE);
	         	$this->load->view('accueil', $data);

		    }
		    else{

		    	// Si l'utilisateur existe bien
		    	if($this->model_membre->verifier_utilisateur_existe($_POST['nom_futur_membre']) == 1){

		    		// Si l'utilisateur n'est pas déjà dans l'équipe

		    		if($this->model_equipe->verifier_appartenance_equipe($id_equipe, $_POST['nom_futur_membre']) == 0){

		    			// Si il n'y a pas déjà une invitation en attente pour cet utilisateur
		    			if($this->model_equipe->invitation_en_cours($id_equipe, $_POST['nom_futur_membre']) == 0){

				    		$this->model_equipe->inviter_membre($_POST['nom_futur_membre'], $data['informations_equipe']['id']);

				    		$this->load->view('accueil', $data);
				    	}
				    	else{

				    		// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		   					$data['formulaire_inviter_membre'] = $this->load->view('formulaire_inviter_membre', NULL, TRUE);
		   					$data['deja_invite'] = "Une invitation pour cette utilisateur est déjà en cours.";

	         				$this->load->view('accueil', $data);
				    	}

		    		}
		    		else{

				    	// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		   				$data['formulaire_inviter_membre'] = $this->load->view('formulaire_inviter_membre', NULL, TRUE);
		   				$data['deja_dans_equipe'] = "Cet utilisateur est déjà dans l'équipe.";

	         			$this->load->view('accueil', $data);
				    }
		    	}
		    	else{

				    // On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		   			$data['formulaire_inviter_membre'] = $this->load->view('formulaire_inviter_membre', NULL, TRUE);
		   			$data['utilisateur_invite_existe_pas'] = "Cet utilisateur n'existe pas.";

	         		$this->load->view('accueil', $data);
				}
		    }
		}
		else{

			// On charge le formulaire pour inviter un membre
			$data['formulaire_inviter_membre'] = $this->load->view('formulaire_inviter_membre', NULL, TRUE);

			$this->load->view('accueil', $data);
		}
	}
}


		?>