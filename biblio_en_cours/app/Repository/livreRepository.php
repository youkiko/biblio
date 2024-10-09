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
	private array $livres = [];

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
			$newLivre = new Livre($livre['id_livre'], $livre['titre'], (int)$livre['nbre_de_pages'], $livre['url_image'], $livre['text-alternatif']);
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

	public function ajouterLivreBdd(string $titre, int $nbreDePage, string $textAlternatif, string $nomImage) {
		$req = "INSERT INTO livre (titre, nbre_de_pages, url_image, `text-alternatif`) VALUES (:titre, :nbre_de_pages, :url_image, :text_alternatif)";
		$stmt = $this->getConnexionBdd()->prepare($req);
		$stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
		$stmt->bindValue(":nbre_de_pages", $nbreDePage, PDO::PARAM_INT);
		$stmt->bindValue(":url_image", $nomImage, PDO::PARAM_STR); // Correction ici
		$stmt->bindValue(":text_alternatif", $textAlternatif, PDO::PARAM_STR); // Correction ici
		$stmt->execute();
		$stmt->closeCursor();
	}


	public function suppimerLivreBdd($idLivre) {
		$req = "DELETE FROM livre WHERE id_livre = :id_livre";
		$stmt = $this->getConnexionBdd()->prepare($req);
		$stmt->bindValue(":id_livre", $idLivre, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->closeCursor();
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
