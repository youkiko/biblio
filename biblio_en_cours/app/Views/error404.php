<?php ob_start() ?>


<p>Le contenu n'est plus disponnible </p>
<p>contacter l'administrateur : <a href="mailto:contacte@monsite.fr">ici</a></p>
<?php
$titre = "page introuvable";
$content = ob_get_clean();
require_once 'template.php';