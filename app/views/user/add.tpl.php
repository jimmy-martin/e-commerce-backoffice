<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
<h2><?= $user->getId() === null ? 'Ajouter' : 'Modifier' ?> un utilisateur</h2>

<div class="alert">
    <?php if (!empty($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="nom.prenom@site.com" value="<?= $user->getEmail() ?>">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Son mot de passe" aria-describedby="passwordHelpBlock">
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
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Prénom" value="<?= $user->getFirstname() ?>">
    </div>
    <div class="form-group">
        <label for="lastname">Nom</label>
        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Nom de famille" value="<?= $user->getLastname() ?>">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="catalog-manager" <?= $user->getRole() == 'catalog-manager' ? ' selected' : '' ?>>Catalog Manager</option>
            <option value="admin" <?= $user->getRole() == 'admin' ? ' selected' : '' ?>>Administrateur</option>
        </select>
    </div>
    <div class="form-group">
        <label for="status">Statut</label>
        <select name="status" id="status" class="form-control">
            <option value="">-</option>
            <option value="1" <?= $user->getStatus() == 1 ? ' selected' : '' ?>>Actif</option>
            <option value="2" <?= $user->getStatus() == 2 ? ' selected' : '' ?>>Désactivé</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>
</div>