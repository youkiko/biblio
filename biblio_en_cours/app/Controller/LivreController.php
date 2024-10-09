<?php

namespace App\Controller;

use Exception;
use App\Repository\livreRepository;

class LivreController
{
	private $repositoryLivres;

	public function __construct()
	{
		$this->repositoryLivres= new livreRepository;
		$this->repositoryLivres->chargementLivresBdd();
	}

	public function afficherLivres(){
		$LivresTab = $this->repositoryLivres->getLivres();
		$pasDeLivre = (count($LivresTab) > 0) ? false : true ; 
		require "../app/Views/livres.php";

	}

	public function afficherUnLivre($idLivre){
		$livre = $this->repositoryLivres->getLivreById($idLivre);
		($livre !== null) ? require "../app/Views/afficherlivre.php" : require "../app/Views/error404.php";
	}

	public function ajouterLivre(){
		require '../app/Views/ajouterLivre.php';
	}

	public function validationAjoutLivre(){

		$image = $_FILES['image'];
		$repertoir = "images/";
		$nomImage =$this->ajouterImage($image, $repertoir);
		$this->repositoryLivres->ajouterLivreBdd($_POST['titre'], $_POST['nbre-de-pages'], $_POST['text-alternatif'], $nomImage);
		header('location: ' . SITE_URL . 'livres');
	}

	public function suppimerLivre($idLivre){
		$nomImage = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage();
		$filename = "images/$nomImage";
		if (file_exists($filename)) unlink($filename);
		$this->repositoryLivres->suppimerLivreBdd($idLivre);
		header('location: ' . SITE_URL . 'livres');
	}


	public function ajouterImage($image, $repertoir){
		if (!isset($_FILES['image']) || empty($_FILES['image']))
			throw new Exception("Vous devez upload une image");
		
			if (!file_exists($repertoir)) mkdir($repertoir, 0777);
		$filename = uniqid() . "-" . $image['name'];
		$target = $repertoir . $filename;

		if (!getimagesize($image['tmp_name']))
			throw new Exception("Vous devez upload une image");

		$extention= strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
		$extentionsTab = ['png', 'webp', 'jpeg'];

		if (!in_array($extention, $extentionsTab))
			throw new Exception("extention non autorisée → ['png', 'webp', 'jpeg'] ");

		if ($image['size'] > 4000000)
			throw new Exception("fichier trop volumineux : max 1MO");

		if (!move_uploaded_file($image['tmp_name'], $target)) 
			throw new Exception("Erreur lors du téléchargement de l'image");

		else
		return $filename;
		
	}
}
