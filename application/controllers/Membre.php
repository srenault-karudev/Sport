<?php

session_start();

defined('BASEPATH') OR exit('No direct script access allowed');

class Membre extends CI_Controller {

	public function __construt(){

		parent::__construct();

		$data['menu_site'] = $this->load->view('menu_site', NULL, TRUE);

	}

	public function connexion(){

		$this->load->model('model_membre');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		// On charge les formulaires ( vides ) qui seront rechargé par la suite si on a intéragit avec eux
		$data['formulaire_connexion'] = $this->load->view('formulaire_connexion', NULL, TRUE);
		$data['formulaire_inscription'] = $this->load->view('formulaire_inscription', NULL, TRUE);

		// Si on a bien essayé de se connecter
		if(isset($_POST['nom_de_compte'])){

			// Règles du formulaire de connexion
			$this->form_validation->set_rules('nom_de_compte', 'Nom_de_compte', 'required|min_length[2]|max_length[20]', array('required' => 'Nom de compte vide', 'min_length' => 'Nom de compte invalide.', 'max_length' => 'Nom de compte invalide.'));
			$this->form_validation->set_rules('mot_de_passe', 'Mot_de_passe', 'required|min_length[2]|max_length[20]', array('required' => 'Mot de passe vide', 'min_length' => 'Mot de passe invalide.', 'max_length' => 'Mot de passe invalide.'));

			// Si le formulaire comporte des erreurs
			if ($this->form_validation->run() == FALSE){

	               	// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
	               	$data['formulaire_connexion'] = $this->load->view('formulaire_connexion', NULL, TRUE);
	                $this->load->view('accueil', $data);
	        }
	        else{

	           	$id = $this->model_membre->connexion($_POST['nom_de_compte'], sha1($_POST['mot_de_passe']));

	           	// On connecte l'utilisateur
				if($id > 0){

					$_SESSION['id'] = $id;
					$_SESSION['login'] = $_POST['nom_de_compte'];

					$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

					$this->load->view('accueil', $data);
				}
				else if($id == -1){

					$data['informations_nom_de_compte'] = "Le compte n'existe pas.";
					$this->load->view('accueil', $data);
				}
				else if($id == -2){

					$data['informations_mot_de_passe'] = "Mot de passe incorrect.";
					$this->load->view('accueil', $data);
				}
	        }
		}
		// On redirige vers l'accueil si on a accédé à cette fonction directement
		else{

			redirect(base_url());
		}
	}

	public function deconnexion($validation){

		if($validation == 1){

			unset($_SESSION['id']);
			unset($_SESSION['login']);

			if(isset($_SESSION['derniere_equipe_memorisee'])){

				unset($_SESSION['derniere_equipe_memorisee']);
			}

			redirect(base_url());
		}
		else{

			$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);
			$this->load->view('accueil', $data);
		}
	}

	public function inscription(){

		$this->load->model('model_membre');
		$this->load->model('model_equipe');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$data['formulaire_connexion'] = $this->load->view('formulaire_connexion', NULL, TRUE);

		// Si on a réellement essayé de s'inscrire
		if(isset($_POST['nom_de_compte_inscription'])){

			// règles des champs du formulaire d'inscription
			$this->form_validation->set_rules('nom_inscription', 'Nom_inscription', 'required|min_length[2]|max_length[20]', array('required' => 'Le nom est vide.', 'min_length' => 'Le nom doit faire au moins 2 caractères.', 'max_length' => 'Le nom ne doit pas dépasser 20 caractères.'));
			$this->form_validation->set_rules('prenom_inscription', 'Prenom_inscription', 'required|min_length[2]|max_length[20]', array('required' => 'Le prénom est vide.', 'min_length' => 'Le prénom doit faire au moins 2 caractères.', 'max_length' => 'Le prénom ne doit pas dépasser 20 caractères.'));
			$this->form_validation->set_rules('nom_de_compte_inscription', 'Nom_de_compte_inscription', 'required|min_length[2]|max_length[20]|is_unique[utilisateurP.login]', array('required' => 'Le nom de compte est vide.', 'min_length' => 'Le nom de compte doit faire au moins 2 caractères.', 'max_length' => 'Le nom de compte ne doit pas dépasser 20 caractères.', 'is_unique' => 'Nom de compte déjà utilisé.'));
			$this->form_validation->set_rules('mot_de_passe_inscription', 'Mot_de_passe_inscription_inscription', 'required|min_length[2]|max_length[20]', array('required' => 'Le mot de passe est vide.', 'min_length' => 'Le mot de passe doit faire au moins 2 caractères.', 'max_length' => 'Le mot de passe ne doit pas dépasser 20 caractères.'));
			$this->form_validation->set_rules('confirmation_mot_de_passe_inscription', 'Confirmation_mot_de_passe_inscription_inscription', 'matches[mot_de_passe_inscription]', array('matches' => 'Les deux mot de passes sont différents.'));
			$this->form_validation->set_rules('email_inscription', 'Email_inscription', 'required|valid_email', array('required' => 'L\'email est vide.', 'valid_email' => 'L\'email n\'est pas valide.'));

			// Si le formulaire comporte des erreurs
			if ($this->form_validation->run() == FALSE){

	     		// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
	      		$data['formulaire_inscription'] = $this->load->view('formulaire_inscription', NULL, TRUE);
	           	$this->load->view('accueil', $data);
	        }

			// Si il n'y a pas d'erreurs dans le formulaire, on inscrit l'utilisateur
			else{

				$this->load->model('model_membre');

				$id = $this->model_membre->ajouter_utilisateur($_POST['nom_de_compte_inscription'], sha1($_POST['mot_de_passe_inscription']), $_POST['nom_inscription'], $_POST['prenom_inscription'], $_POST['email_inscription']);
						
				$_SESSION['id'] = $id;
				$_SESSION['login'] = $_POST['nom_de_compte_inscription'];

				$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

				$this->load->view('accueil', $data);

			}
		}
		// On redirige vers l'accueil si on a accédé à cette fonction directement
		else{

			redirect(base_url());
		}
	}

}