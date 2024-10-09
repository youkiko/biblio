<?php

declare(strict_types=1);

use App\Controller\LivreController;

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

require __DIR__ . '/app/lib/init.php';
require __DIR__ . '/app/lib/functions.php';
?>
<?php
$livreController= new LivreController;
try {
    // debug($_GET, $mode = 0);
    if (empty($_GET['page'])) {
        require 'app/Views/accueil.php';
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case 'livres':
				if(empty($url[1])){
					$livreController->afficherLivres();
				} else if ($url[1] === 'l'){
					$livreController->afficherUnLivre((int)$url[2]);
				}else if ($url[1] === 'a'){
					$livreController->ajouterLivre();
				}  else if ($url[1] === 'av'){
					$livreController->validationAjoutLivre();
				} else if ($url[1] === 'm'){
					echo "modification des details d'un livre";
				} else if ($url[1] === 's'){
					$livreController->suppimerLivre((int)$url[2]);
				} else {
					throw new Exception("la page n'existe pas");
				}
                break;
			default : 
				throw new Exception("la page n'existe pas");
				break;
        }
    }
} catch (Exception $e) {
	$message = $e->getMessage();
    require '../app/Views/error404.php';
}
