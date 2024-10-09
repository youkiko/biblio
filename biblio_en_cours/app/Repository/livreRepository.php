<?php

namespace App\Repository;

use App\service\AbstractConnexion;
use App\Models\Livre;
use PDO;

class livreRepository extends AbstractConnexion
{
	/**
	 * tableau de livres
	 *
	 * @var array
	 */
	private array $livres;

	public function ajouterlivre(object $nouveauLivre){
		$this->livres[]=$nouveauLivre;
	}

	public function chargementLivresBdd(){
		// protection injection sql
		$req = $this->getConnexionBdd()->prepare("SELECT * FROM livre");
		$req->execute();
		$livreImportes = $req->fetchALL(PDO::FETCH_ASSOC);
		$req->closeCursor();
		foreach($livreImportes as $livre){
			$newLivre = new Livre($livre['id_livre'], $livre['titre'], $livre['nbre_de_pages'], $livre['url_image'], $livre['text-alternatif']);
			$this->ajouterlivre($newLivre);
		}
	}


	public function getLivreById($idLivre) {
		$this->getLivres();
		foreach($this->livres as $livre) {
			if ($livre->getId() === $idLivre){
			return $livre;
			}
		}
	}

	/**
	 * Get the value of livres
	 *
	 * @return array
	 */
	public function getLivres(): array {
		return $this->livres;
	}
}
