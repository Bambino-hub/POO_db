<div class="container">
    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>Titre</th>
            <th>Contenu</th>
            <th>Actif</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach ($annonces as $annonce) : ?>
                <tr>
                    <td><?= $annonce->id ?></td>
                    <td><?= $annonce->titre ?></td>
                    <td><?= $annonce->description ?></td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch <?= $annonce->id ?>" <?= $annonce->actif ? 'checked' : '' ?>>
                            <label class=" custom-control-label" for="customSwitch1 <?= $annonce->id ?>"></label>
                        </div>
                    </td>
                    <td> <a href="index.php?p=annonce/editAnnonce/<?= $annonce->id ?>" class="btn btn-warning">Modifié</a>
                        <a href="index.php?p=admin/deleteAnnonce/<?= $annonce->id ?>" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>