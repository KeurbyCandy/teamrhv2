<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneProspectComById($db, $_GET['id']);
$r_prospect = getOneProspectById($db, $r->prospect);
?>

<div class="container">
    <form action="../functions/upd_prospect_com.php" method="POST">
        <input type="hidden" name="input_id" id="input_id" value="<?= $r->id ?>" />
        <input type="hidden" name="input_id_prospect" id="input_id" value="<?= $r_prospect->id ?>" />
        <div class="row">
            <div class="col-lg-9">
                <h1>Commentaire : <a href="upd_prospect.php?id=<?= $r_prospect->id ?> "><?= $r_prospect->nom ?></a></h1>
            </div>
            <div class="col-lg-3">
                <h1 class="pull-right"><button type="submit" class="btn btn-primary">Enregistrer commentaire</button></h1>
            </div>
        </div>
        <div class="jumbotron">
            <label for="remarque">Remarque :</label>
            <textarea 
                name="remarque" id="remarque" class="form-control" rows="5"><?= $r->remarque ?></textarea>
        </div>
    </form>
</div>
</body>
