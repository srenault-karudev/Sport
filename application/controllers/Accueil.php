<?php

session_start();

defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {

	public function __construt(){

		parent::__construct();

	}

	public function index(){

		// on charge les differents model pour faire appel aux fonctions

		$this->load->model('model_membre');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');


		// On charge les formulaires ( vides ) qui seront rechargé par la suite si on a intéragit avec eux
		$data['formulaire_connexion'] = $this->load->view('formulaire_connexion', NULL, TRUE);
		$data['formulaire_inscription'] = $this->load->view('formulaire_inscription', NULL, TRUE);

		// Si on est connnecté

		if(isset($_SESSION['id'])){

			// ON récupère les informations  et on affiche la vue
			
			$data = $this->model_membre->get_informations_utilisateur($_SESSION['id']);

			$this->load->view('accueil', $data);
		}
			
		// Si on vient d'arriver sur la page
		else{

	        $this->load->view('accueil', $data);
		}
	}

}
