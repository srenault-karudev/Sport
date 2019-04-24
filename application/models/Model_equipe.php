<?php 

class Model_equipe extends CI_Model {

	public function __construct(){
		$this->load->database();
	}


/*	methode get_informations_utilisateur

	**	renvoie -1 si l'utilisateur n'existe pas
	**	renvoie un tableau contenant les informations si l'utilisateur existe

	*/

	public function get_liste_invitations_equipes(){

		$sql = "SELECT invitations_equipeP.id_equipe, equipeP.nom FROM invitations_equipeP INNER JOIN equipeP ON invitations_equipeP.id_equipe = equipeP.id WHERE nom_de_compte = ?";
		$req = $this->db->query($sql, array($_SESSION['login']));

//rettourne un tableau d'objet 

		$res = $req->result_array();

		return $res;

	}

	public function ajouter_equipe($nom_equipe, $mot_de_passe_inscription, $sport, $ville, $description, $mixite, $logo, $image){
		
		$sql = "INSERT INTO equipeP (nom, mot_de_passe_inscription, sport, ville, description, mixite, logo, image) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
		$req = $this->db->query($sql, array($nom_equipe, $mot_de_passe_inscription, $sport, $ville, $description, $mixite, $logo, $image));

		$sql = "SELECT * FROM equipeP WHERE nom = ?";
		$req = $this->db->query($sql, array($nom_equipe));

		$row = $req->row();

		$id = $row->id;

		$sql = "INSERT INTO membres_equipeP (id_equipe, id_membre, rang) VALUES ( ?, ?, 0)";
		$req = $this->db->query($sql, array($id, $_SESSION['id']));

	}
	

	public function get_liste_equipes(){

		$sql = "SELECT membres_equipeP.id_equipe, equipeP.nom FROM membres_equipeP INNER JOIN equipeP ON membres_equipeP.id_equipe = equipeP.id WHERE id_membre = ?";
		$req = $this->db->query($sql, array($_SESSION['id']));

		$res = $req->result_array();

		return $res;
	}

	public function verifier_appartenance_equipe($id_equipe, $nom=NULL){

		
		// Si on ne veut pas vérifier en fonction d'un nom mais en fonction de nous même
		if($nom == NULL){		

			$id_final = $_SESSION['id'];

		}
		else{

			$sql = "SELECT * FROM utilisateurP WHERE login = ?";
			$req = $this->db->query($sql, array($nom));

			$row = $req->row();

			$id_final = $row->id;

		}

		$sql = "SELECT * FROM membres_equipeP WHERE id_equipe = ? AND id_membre = ?";
		$req = $this->db->query($sql, array($id_equipe, $id_final));

		$res = $req->num_rows();

		if($res == 1){

			return 1;
		}
		else{

			return 0;
		}

	}


	public function get_informations_equipe($id_equipe){

		$sql = "SELECT * FROM equipeP WHERE id = ?";
		$req = $this->db->query($sql, array($id_equipe));

		$res = $req->row_array();

		return $res;
	}


	public function get_rang_equipe($id_equipe){

		$sql = "SELECT rang FROM membres_equipeP WHERE id_equipe = ? AND id_membre = ?";
		$req = $this->db->query($sql, array($id_equipe, $_SESSION['id']));

		$row = $req->row();

		return $row->rang;

	}

	public function get_id_equipe($nom_equipe){

		$sql = "SELECT id FROM equipeP WHERE nom = ?";
		$req = $this->db->query($sql, array($nom_equipe));

		$res = $req->num_rows();

		if($res == 0){

			return 0;

		}
		else{

			$row = $req->row();

			return $row->id;

		}

	}

	
	public function verifier_invitation_equipe($id_equipe){

		$sql = "SELECT * FROM invitations_equipeP WHERE id_equipe = ? AND nom_de_compte = ?";
		$req = $this->db->query($sql, array($id_equipe, $_SESSION['login']));

		$res = $req->num_rows();

		if($res == 1){

			return 1;
		}
		else{

			return 0;
		}
	}

	public function invitation_en_cours($id_equipe, $nom_utilisateur){

		$sql = "SELECT * FROM invitations_equipeP WHERE id_equipe = ? AND nom_de_compte = ?";
		$req = $this->db->query($sql, array($id_equipe, $nom_utilisateur));

		$res = $req->num_rows();

		if($res == 1){

			return 1;
		}
		else{

			return 0;
		}

	}


	public function rejoindre_equipe($id_equipe){

		$sql = "INSERT INTO membres_equipeP (id_equipe, id_membre, rang) VALUES ( ?, ?, 3)";
		$req = $this->db->query($sql, array($id_equipe, $_SESSION['id']));

		$sql = "DELETE FROM invitations_equipeP WHERE id_equipe = ? AND nom_de_compte = ?";
		$req = $this->db->query($sql, array($id_equipe, $_SESSION['login']));
	}


	public function rejoindre_equipe_via_mot_de_passe($nom_equipe, $mot_de_passe){

		$sql = "SELECT * FROM equipeP WHERE nom = ? AND mot_de_passe_inscription = ?";
		$req = $this->db->query($sql, array($nom_equipe, $mot_de_passe));

		$res = $req->num_rows();

		if($res == 1){

			$id_equipe = $this->get_id_equipe($nom_equipe);

			$sql = "INSERT INTO membres_equipeP (id_equipe, id_membre, rang) VALUES ( ?, ?, 3)";
			$req = $this->db->query($sql, array($id_equipe, $_SESSION['id']));

			return 1;

		}
		else{

			return 0;
		}

		

	}

	public function ajouter_entraineur($nom_entraineur, $id_equipe){

		$sql = "SELECT * FROM utilisateurP WHERE login = ?";
		$req = $this->db->query($sql, array($nom_entraineur));

		$row = $req->row();

		$id_entraineur = $row->id;

		$sql = "UPDATE membres_equipeP SET rang = 1 WHERE id_equipe = ? AND id_membre = ?";
		$req = $this->db->query($sql, array($id_equipe, $id_entraineur));
	}


	public function inviter_membre($nom_futur_membre, $id_equipe){

		$sql = "INSERT INTO invitations_equipeP (id_equipe, nom_de_compte) VALUES ( ?, ?)";
		$req = $this->db->query($sql, array($id_equipe, $nom_futur_membre));
	}

	public function get_nombre_equipes_actuel(){

		$sql = "SELECT * FROM membres_equipeP WHERE id_membre = ?";
		$req = $this->db->query($sql, array($_SESSION['id']));

		$res = $req->num_rows();

		return $res;
	}


}




?>