<?php ob_start() ?>

<form method="POST" action="<?= SITE_URL ?>livres/av" enctype="multipart/form-data">
	<div class="form-group my-4">
		<label for="titre">Titre : </label>
		<input type="text" class="form-control" id="titre" name="titre">
	</div>
	<div class="form-group my-4">
		<label for="nbre-de-pages">Nombre de page : </label>
		<input type="number" class="form-control" id="nbre-de-pages" name="nbre-de-pages">
	</div>
	<div class="form-group my-4">
		<label for="text-alternatif">text alternatif : </label>
		<textarea class="form-control" id="text-alternatif" name="text-alternatif"></textarea>
	</div>
	<div class="form-group my-4">
		<label for="image">Image : </label>
		<input type="file" class="form-control" id="image" name="image"></input>
	</div>
	<button class="btn btn-info">Créer livre</button>
</form>



<?php
$titre = "Ajouter Livre";
$content = ob_get_clean();
require_once 'template.php';
