<?php
//branchement avec la librairie de fonctions
require_once("../outils/fonctions.php");

//si on recoit par le biais de l'URL (méthode GET) le paramètre "action"
if(isset($_GET['action']))
	{
	//on se connecte à la base de données
	$connexion=connexion();
	
	switch($_GET['action'])
		{
		case "afficher_contact":
		
		$titre="Liste des contacts";
		$tab_resultat=afficher_contacts();
		
		break;

		case "supprimer_contact":
		$titre="Liste des contacts";
		$action_form="suprimer_compte";
		
		//si on reçoit par la méthode GET (url) une variable id_contact
		//c.a.d que l'internaute a appuyé sur la croix
		if(isset($_GET['id_contact']))
			{
			$avertissement="Êtes-vous sûr de vouloir supprimer le contact n° ".$_GET['id_contact']." ?<br />"; 	
			$avertissement.="<div class=\"bt\">\n<a href=\"index.php?action=supprimer_contact&id_contact=".$_GET['id_contact']."&confirmation=oui\">OUI</a>&nbsp;&nbsp;<a href=\"index.php?action=afficher_contact\">NON</a>\n</div>\n";
			}
		if(isset($_GET['confirmation']))
			{
			//on va supprimer la ligne qui a été désignée
			$requete="DELETE FROM contacts WHERE id_contact='".$_GET['id_contact']."'";
			$resultat=mysqli_query($connexion,$requete);
			$avertissement="Le contact n° ".$_GET['id_contact']." a bien été supprimé";
			}

		$tab_resultat=afficher_contacts();
		
		break;
		
		case "inserer_compte":
		$titre="Liste des comptes";
		$formulaire="form_comptes.html";
		$bouton="CREE";
		$action_form="inserer_compte";
		if(isset($_POST['submit']))
		{
			$requete="INSERT INTO comptes SET nom_compte='".$_POST['nom_compte']."',
											  prenom_compte='".$_POST['prenom_compte']."',
											  email_compte='".$_POST['email_compte']."',
											  pass_compte='".$_POST['pass_compte']."'";
											  $resulta=mysqli_query($connexion,$requete);
											  $avertissement="Le compte a bien été créé";
			
		}
		$tab_resultat=afficher_comptes();
		
		break;
		
		case "supprimer_compte":
		$titre="Liste des comptes";
		$formulaire="form_comptes.html";
		$bouton="CREE";
		$action_form="inserer_compte";
		if(isset($_GET['id_compte']))
			{
			$avertissement="Êtes-vous sûr de vouloir supprimer le compte n° ".$_GET['id_compte']." ?<br />"; 	
			$avertissement.="<div class=\"bt\">\n<a href=\"index.php?action=supprimer_compte&id_compte=".$_GET['id_compte']."&confirmation=oui\">OUI</a>&nbsp;&nbsp;<a href=\"index.php?action=inserer_compte\">NON</a>\n</div>\n";
			}
		if(isset($_GET['confirmation']))
			{
			//on va supprimer la ligne qui a été désignée
			$requete="DELETE FROM comptes WHERE id_compte='".$_GET['id_compte']."'";
			$resultat=mysqli_query($connexion,$requete);
			$avertissement="Le compte n° ".$_GET['id_compte']." a bien été supprimé";
			}
		$tab_resultat=afficher_comptes();
		break;
		
		case "modifier_compte":
		$titre="Liste des comptes";
		$formulaire="form_comptes.html";
		$bouton="MODIFIER";
		
		
			if(isset($_POST['submit']))
				
	{
		$requete="UPDATE comptes SET nom_compte='".addslashes($_POST['nom_compte'])."',
										  prenom_compte='".addslashes($_POST['prenom_compte'])."',
										  email_compte='".$_POST['email_compte']."',
										  pass_compte='".addslashes($_POST['pass_compte'])."'
		WHERE id_compte='".$_GET['id_compte']."'";
		$resultat=mysqli_query($connexion, $requete);
		$avertissement="le compte a bien été modifier";
		
	}
		if(isset($_GET['id_compte']))
		{
			$action_form="modifier_compte&id_compte=" . $_GET['id_compte'] . "";
			$requete="SELECT * FROM comptes WHERE id_compte='".$_GET['id_compte']."'";
			$resultat=mysqli_query($connexion, $requete);
			$ligne=mysqli_fetch_object($resultat);
			$_POST['nom_compte']=stripslashes($ligne->nom_compte);
			$_POST['prenom_compte']=stripslashes($ligne->prenom_compte);
			$_POST['email_compte']=stripslashes($ligne->email_compte);
			$_POST['pass_compte']=stripslashes($ligne->pass_compte);			
		}

		$tab_resultat=afficher_comptes();
		break;
		}
	mysqli_close($connexion);
	}
else{
	$titre="Bienvenu";
	}

//liaison avec le fichier html
include("index.html");
?>