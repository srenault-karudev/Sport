<?php 

class Model_evenement extends CI_Model {

	public function __construct(){
		$this->load->database();
	}



	
public function creer_evenement($id_equipe, $type, $debut, $fin, $lieu, $description){

		$sql = "INSERT INTO evenementP (id_equipe, type, lieu, description) VALUES ( ?, ?, ?, ?)";
		$req = $this->db->query($sql, array($id_equipe, $type, $lieu, $description));
	}

	public function get_liste_evenements($id_equipe){

		$sql = "SELECT evenementP.* FROM evenementP INNER JOIN equipeP ON evenementP.id_equipe = equipeP.id WHERE id_equipe = ?";
		$req = $this->db->query($sql, array($id_equipe));

		$res = $req->result_array();

		return $res;
	}

	public function get_informations_evenement($id_evenement){

		$sql = "SELECT * FROM evenementP WHERE id = ?";
		$req = $this->db->query($sql, array($id_evenement));

		$res = $req->row_array();

		return $res;
	}

	

	public function get_liste_participants_evenement($id_evenement){

		$sql = "SELECT participants_evenementP.id_participant, participants_evenementP.id_evenement, utilisateurP.login FROM participants_evenementP INNER JOIN utilisateurP ON participants_evenementP.id_participant = utilisateurP.id WHERE id_evenement = ?";
		$req = $this->db->query($sql, array($id_evenement));

		$res = $req->result_array();

		return $res;		
	}

	public function verifier_evenement_appartient_equipe($id_equipe, $id_evenement){

		$sql = "SELECT * FROM evenementP WHERE id = ?";
		$req = $this->db->query($sql, array($id_evenement));

		$row = $req->row();

		$id_evemenet_bdd = $row->id;

		if($id_evemenet_bdd == $id_evenement){

			return 1;
		}
		else{

			return 0;
		}
	}

	public function ajouter_participant_evenement($id_evenement, $id_participant){

		$sql = "INSERT INTO participants_evenementP (id_evenement, id_participant) VALUES ( ?, ?)";
		$req = $this->db->query($sql, array($id_evenement, $id_participant));
	}
}