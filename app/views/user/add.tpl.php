<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Ajouter un utilisateur</h2>

<div class="alert">
  <?php if (!empty($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
      <p><?= $error ?></p>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="lastname">Nom</label>
        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom">
    </div>
    <div class="form-group">
        <label for="firstname">Prénom</label>
        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe"aria-describedby="passwordHelpBlock">
        <small id="passwordHelpBlock" class="form-text text-muted">
            Le mot de passe doit contenir:
            <ul>
                <li>au moins 8 caractères</li>
                <li>au moins une lettre en minuscule</li>
                <li>au moins une lettre en majuscule</li>
                <li>au moins un chiffre</li>
                <li>au moins un caractère spécial ('_', '-', '|', '%', '&', '*', '=', '@', '$')</li>
            </ul>
        </small>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="custom-select" name="status" id="status">
            <option value="1" selected>Actif</option>
            <option value="2">Désactivé / Bloqué</option>
        </select>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select class="custom-select" name="role" id="role">
                <option value="admin">Admin</option>
                <option value="catalog-manager" selected>Catalog manager</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>