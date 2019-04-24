<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// toutes les vérifications concernant les lien ( si on est bien connecté, si on fait bien parti de l'équipe etc etc )

// vérifier qu'on ne peut pas rejoindre une équipe par invitation si on en a déjà 5

// verifier que l'entraineur désiré appartient bien a l'équipe

// verifier que seul l'admin peut inviter / designer entraineur etc etc

// rajouter périodicité

// tous les ehco doivent avoir des htmlspecialchars

// dates valides

// Pouvoir quitter une équipe

// Pour créer un trigger il faut mettre un compte externe : login@%, et pas localhost sinon on n'aura pas les droits

// verification des infos via l'url ( notamment pour equipe )


class Model_membre extends CI_Model {

	public function __construct(){
		$this->load->database();
	}


	/* 	methode connexion

	**	Renvoie -1 si l'utilisateur n'existe pas
	**	Renvoie -2 si le mot de passe est incorrect
	**	Renvoie l'identifiant si le nom d'utilisateur et le mot de passe sont correct

	*/

	public function connexion($nom_de_compte, $mot_de_passe){


		$sql = "SELECT * FROM utilisateurP WHERE login = ?";
		$req = $this->db->query($sql, array($nom_de_compte));

		$res = $req->num_rows();

		if($res == 1){

			$sql = "SELECT * FROM utilisateurP WHERE login = ? AND password = ?";
			$req = $this->db->query($sql, array($nom_de_compte, $mot_de_passe));

			$res = $req->num_rows();

			if($res == 1){

				$row = $req->row();

				$id = $row->id;

				return $id;
			}
			else{

				return -2;
			}
		}
		else
		{
			return -1;
		}

	}

	/*	methode get_informations_utilisateur

	**	renvoie -1 si l'utilisateur n'existe pas
	**	renvoie un tableau contenant les informations si l'utilisateur existe

	*/

	public function get_informations_utilisateur($id){

		$sql = "SELECT * FROM utilisateurP WHERE id = ?";
		$req = $this->db->query($sql, array($id));

// on retourn le nombre de lignes 

		$res = $req->num_rows();

		if($res == 1){

			$row = $req->row();

			$data['login'] = $row->login;
			$data['password'] = $row->password;
			$data['nom'] = $row->nom;
			$data['prenom'] = $row->prenom;
			$data['email'] = $row->email;
			$data['avatar'] = $row->avatar;

			$sql = "SELECT * FROM membres_equipeP WHERE id_membre = ?";
			$req = $this->db->query($sql, array($id));

			$data['nombre_equipes'] = $req->num_rows();


			return $data;
		}
		else{

			return -1;

		}
	}

	public function verifier_utilisateur_existe($nom_de_compte){

		$sql = "SELECT * FROM utilisateurP WHERE login = ?";
		$req = $this->db->query($sql, array($nom_de_compte));

		// on retourne le nombre de lignes 

		$res = $req->num_rows();

		if($res == 1){

			return 1;
		}
		else{

			return 0;
		}
	}

	public function ajouter_utilisateur($nom_de_compte, $mot_de_passe, $nom, $prenom, $email){

		$sql = "INSERT INTO utilisateurP (login, password, nom, prenom, email, avatar) VALUES ( ?, ?, ?, ?, ?, 'automatique.png')";
		$req = $this->db->query($sql, array($nom_de_compte, $mot_de_passe, $nom, $prenom, $email));

		$sql = "SELECT * FROM utilisateurP WHERE login = ? AND password = ?";
		$req = $this->db->query($sql, array($nom_de_compte, $mot_de_passe));

// $row = compte le nombre de lignes

		$row = $req->row();

// chaque ligne est un numero qui va ensuite represente comme un id  
		$id = $row->id;

		return $id;
	}

	public function get_liste_utilisateurs(){

		$req = $this->db->query("SELECT login FROM utilisateurP");

		//retourne le resultat sous forme d'un tableau d'objets

		$res = $req->row_array();

		return $data;
	}

}