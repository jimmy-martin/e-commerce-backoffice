<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Ajouter un utilisateur</h2>

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
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="custom-select" name="status" id="status" aria-describedby="brandHelpBlock">
                <option value="1">Actif</option>
                <option value="2">Désactivé / Bloqué</option>
        </select>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select class="custom-select" name="role" id="role" aria-describedby="brandHelpBlock">
                <option value="admin">Admin</option>
                <option value="catalog-manager">Catalog manager</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>