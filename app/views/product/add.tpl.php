<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Ajouter un produit</h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Nom du produit" value="<?=!empty($product) ? $product->getName() : '' ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" id="description" placeholder="Sous-titre" 
            aria-describedby="descriptionHelpBlock" value="<?= !empty($product) ? $product->getDescription() : '' ?>">
        <small id="subtitleHelpBlock" class="form-text text-muted">
            La description du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value="<?= !empty($product) ? $product->getPicture() : '' ?>">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur 
            <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="price">Prix</label>
        <input type="number" class="form-control" name="price" id="price" placeholder="Prix" 
            aria-describedby="priceHelpBlock" value="<?= !empty($product) ? $product->getPrice() : '' ?>">
        <small id="priceHelpBlock" class="form-text text-muted">
            Le prix du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="rate">Note</label>
        <input type="text" class="form-control" name="rate" id="rate" placeholder="Note" 
            aria-describedby="rateHelpBlock" value="<?= !empty($product) ? $product->getRate() : '' ?>">
        <small id="rateHelpBlock" class="form-text text-muted">
            Le note du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="status">Statut</label>
        <select class="custom-select" name="status" id="status" aria-describedby="statusHelpBlock">
            <option value="0">Inactif</option>
            <option value="1">Actif</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le statut du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="category">Catégorie</label>
        <select class="custom-select" name="category" id="category" aria-describedby="categoryHelpBlock">
            <option value="1">Détente</option>
            <option value="2">Au travail</option>
            <option value="3">Cérémonie</option>
        </select>
        <small id="categoryHelpBlock" class="form-text text-muted">
            La catégorie du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="brand">Marque</label>
        <select  class="custom-select" name="brand" id="brand" aria-describedby="brandHelpBlock">
            <option value="1">oCirage</option>
            <option value="2">BOOTstrap</option>
            <option value="3">Talonette</option>
        </select>
        <small id="brandHelpBlock" class="form-text text-muted">
            La marque du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="type">Type</label>
        <select class="custom-select" name="type" id="type" aria-describedby="typeHelpBlock">
            <option value="1">Chaussures de ville</option>
            <option value="2">Chaussures de sport</option>
            <option value="3">Tongs</option>
        </select>
        <small id="typeHelpBlock" class="form-text text-muted">
            Le type de produit 
        </small>
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>