<?php

namespace App\Controller;

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
		require "../app/Views/livres.php";
	}

	public function afficherUnLivre($idLivre){
		$livre = $this->repositoryLivres->getLivreById($idLivre);
		($livre !== null) ? require "../app/Views/afficherlivre.php" : require "../app/Views/error404.php";
	}
}
