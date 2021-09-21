<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Ajouter un produit</h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Nom du produit" value="<?= $product->getName() ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" id="description" placeholder="Description du produit" aria-describedby="descriptionHelpBlock" value="<?= $product->getDescription() ?>">
        <small id="subtitleHelpBlock" class="form-text text-muted">
            La description du produit
        </small>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock" value="<?= $product->getPicture() ?>">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur
            <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="price">Prix</label>
        <input type="number" class="form-control" name="price" id="price" placeholder="Prix" aria-describedby="priceHelpBlock" value="<?= $product->getPrice() ?>">
        <small id="priceHelpBlock" class="form-text text-muted">
            Le prix du produit
        </small>
    </div>
    <div class="form-group">
        <label for="rate">Note</label>
        <input type="text" class="form-control" name="rate" id="rate" placeholder="Note" aria-describedby="rateHelpBlock" value="<?= $product->getRate() ?>">
        <small id="rateHelpBlock" class="form-text text-muted">
            Le note du produit
        </small>
    </div>
    <div class="form-group">
        <label for="status">Statut</label>
        <select class="custom-select" name="status" id="status" aria-describedby="statusHelpBlock">
            <option value="2" <?= $product->getStatus() == 2 ? 'selected' : '' ?>>Inactif</option>
            <option value="1" <?= $product->getStatus() == 1 ? 'selected' : '' ?>>Actif</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le statut du produit
        </small>
    </div>
    <div class="form-group">
        <label for="category">Categorie</label>
        <select class="custom-select" name="category_id" id="category" aria-describedby="categoryHelpBlock">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category->getId() ?>" <?= $product->getCategoryId() == $category->getId() ? 'selected' : '' ?>><?= $category->getName() ?></option>
            <?php endforeach ?>
        </select>
        <small id="categoryHelpBlock" class="form-text text-muted">
            La catégorie du produit
        </small>
    </div>
    <div class="form-group">
        <label for="brand">Marque</label>
        <select class="custom-select" name="brand_id" id="brand" aria-describedby="brandHelpBlock">
            <?php foreach ($brands as $brand) : ?>
                <option value="<?= $brand->getId() ?>" <?= $product->getBrandId() == $brand->getId() ? 'selected' : '' ?>><?= $brand->getName() ?></option>
            <?php endforeach ?>
        </select>
        <small id="brandHelpBlock" class="form-text text-muted">
            La marque du produit
        </small>
    </div>
    <div class="form-group">
        <label for="type">Type</label>
        <select class="custom-select" name="type_id" id="type" aria-describedby="typeHelpBlock">
        <?php foreach ($types as $type) : ?>
                <option value="<?= $type->getId() ?>" <?= $product->getTypeId() == $type->getId() ? 'selected' : '' ?>><?= $type->getName() ?></option>
            <?php endforeach ?>
        </select>
        <small id="typeHelpBlock" class="form-text text-muted">
            Le type de produit
        </small>
    </div>
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>