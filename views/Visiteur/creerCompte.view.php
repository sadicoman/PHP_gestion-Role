<h1>Création de comtpe</h1>
<form method="POST" action="validation_creerCompte">
    <div class="mb-3">
        <label for="login" class="form-label">Login</label>
        <input type="text" class="form-control" id="login" name="login" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mots de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="mail" class="form-label">Mail</label>
        <input type="mail" class="form-control" id="mail" name="mail" required>
    </div>
    <button type="submit" class="btn btn-primary">Créer !</button>
</form>