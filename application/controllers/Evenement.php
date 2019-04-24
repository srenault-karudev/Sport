<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include("Equipe.php");

class Evenement extends Equipe {

	public function __construt(){

		parent::__construct();

	}

	public function creer_evenement($id_equipe){


	$this->load->model('model_membre');
	$this->load->model('model_evenement');
	$this->load->model('model_equipe');
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');


		// On recharge les informations de l'utilisateur
		$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

		$data = $data + $this->afficher_informations_equipe($id_equipe,0);

		// Si on a essayé de creer un evenement
		if(isset($_POST['debut'])){

			$this->form_validation->set_rules('type', 'Type', 'required', array('required' => 'Un type est requis.'));
			$this->form_validation->set_rules('lieu', 'Lieu', 'required|min_length[2]|max_length[20]', array('required' => 'Le lieu est vide.', 'min_length' => 'Le lieu doit faire au moins 2 caractères.', 'max_length' => 'Le lieu ne doit pas dépasser 20 caractères.'));
			$this->form_validation->set_rules('description', 'Description', 'required|min_length[2]', array('required' => 'La description est vide.', 'min_length' => 'La description doit faire au moins 2 caractères.'));

			// Si le formulaire comporte des erreurs
			if ($this->form_validation->run() == FALSE){

		     	// On recharge la vue avec le formulaire contenant les messages d'erreurs et les champs déjà remplis
		   		$data['formulaire_creation_evenement'] = $this->load->view('formulaire_creation_evenement', NULL, TRUE);
	         	$this->load->view('accueil', $data);

		    }
		    else{

		    	$this->model_evenement->creer_evenement($data['informations_equipe']['id'], $_POST['type'], $_POST['debut'], $_POST['fin'], $_POST['lieu'], $_POST['description']);

		    	$url = base_url() . '/Equipe/afficher_informations_equipe/' . $_SESSION['derniere_equipe_memorisee'] . '#evenements';

				redirect($url);
		    }
		}
		else{

			// On charge le formulaire pour inviter un membre
			$data['formulaire_creation_evenement'] = $this->load->view('formulaire_creation_evenement', NULL, TRUE);

			$this->load->view('accueil', $data);
		}
	}


public function consulter_evenement($id_evenement){

        $this->load->model('model_evenement');
        $this->load->model('model_equipe');

		$data = $this->afficher_informations_equipe($_SESSION['derniere_equipe_memorisee'], 0);

		$appartenance = $this->model_evenement->verifier_evenement_appartient_equipe($_SESSION['derniere_equipe_memorisee'], $id_evenement);

		// Si l'evenement appartient bien a l'équipe dont on fait partit
		if($appartenance == 1){

			$data['informations_evenement'] = $this->model_evenement->get_informations_evenement($id_evenement);

			$this->load->view('accueil', $data);

		}
		else{

			$this->load->view('accueil', $data);
		}
	}




	public function liste_participants_evenement($id_evenement){

		$this->load->model('model_evenement');
		$this->load->model('model_equipe');

		$data = $this->afficher_informations_equipe($_SESSION['derniere_equipe_memorisee'], 0);

		$appartenance = $this->model_evenement->verifier_evenement_appartient_equipe($_SESSION['derniere_equipe_memorisee'], $id_evenement);

		// Si l'evenement appartient bien a l'équipe dont on fait partit
		if($appartenance == 1){

			$data['liste_participants_evenement'] = $this->model_evenement->get_liste_participants_evenement($id_evenement);
			$data['id_evenement'] = $id_evenement;
 			
 			$this->load->view('accueil', $data);
		}
		else{

			$this->load->view('accueil', $data);
		}
	}

	public function participer_evenement($id_evenement){

		$this->load->model('model_evenement');
		$this->load->model('model_equipe');

		$data = $this->afficher_informations_equipe($_SESSION['derniere_equipe_memorisee'], 0);

		$appartenance = $this->model_evenement->verifier_evenement_appartient_equipe($_SESSION['derniere_equipe_memorisee'], $id_evenement);

		// Si l'evenement appartient bien a l'équipe dont on fait partit
		if($appartenance == 1){

			$this->model_evenement->ajouter_participant_evenement($id_evenement, $_SESSION['id']);
 			
 			$url = base_url() . '/Evenement/liste_participants_evenement/' . $id_evenement .'#evenements';

			redirect($url);
		}
		else{

			$this->load->view('accueil', $data);
		}
	}
}