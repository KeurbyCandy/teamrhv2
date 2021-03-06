<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

$r = getOneContactById($db, $id);
$r_client = getOneCustomerById($db, $r->client);
?>

<div class="container">
    <h1>Fiche Contact - <a href="upd_client.php?id=<?= $r_client->id ?>"><?= $r_client->nom ?></a></h1>
    <form class="form-horizontal" method="POST" action="../functions/upd_contact.php" id="form_rdv">
        <input type="hidden" name="id" value="<?= $r->ID ?>" />
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_civil" class="col-lg-2 control-label">Identité</label>
                            <div class="col-lg-3">			
                                <select class="form-control" name="input_civil" >
                                    <OPTION value=""      <?php if ($r->civilite == '') echo 'selected'; ?>      >     </OPTION>
                                    <OPTION value="Melle" <?php if ($r->civilite == 'Melle') echo 'selected'; ?> >Melle</OPTION>
                                    <OPTION value="Mme"   <?php if ($r->civilite == 'Mme') echo 'selected'; ?>   >Mme  </OPTION>
                                    <OPTION value="Mr"    <?php if ($r->civilite == 'Mr') echo 'selected'; ?>    >Mr   </OPTION>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="input_name" 
                                       id="input_name" placeholder="Nom" 
                                       value="<?= $r->nom ?>" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="input_last" 
                                       id="input_last" placeholder="Prénom" 
                                       value="<?= $r->prenom ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_statut" class="col-lg-2 control-label">Statut</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="input_statut" 
                                        id="input_statut" required>
                                    <option value="N" <?php if ($r->inactif == 'N') echo 'selected'; ?>>Actif</option>
                                    <option value="Y" <?php if ($r->inactif == 'Y') echo 'selected'; ?>>Inactif</option>
                                </select>
                            </div>
                            <label for="input_tel" class="col-lg-2 control-label">Téléphone</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="input_tel" 
                                       id="input_tel" placeholder="Téléphone" 
                                       value="<?= $r->tel ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_fonction" class="col-lg-2 control-label">Fonction</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_fonction" 
                                       id="input_fonction" placeholder="Fonction" 
                                       value="<?= $r->fonction ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_remarque" class = "col-lg-2 control-label">Remarque</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="input_remarque" 
                                          name="input_remarque" placeholder="Remarque" 
                                          type="text" rows="7"><?= $r->remarque ?></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_mail" class="col-lg-2 control-label"><a href="mailto:<?= $r->email ?>">Email</a></label>
                            <div class="col-lg-10">
                                <input type="email" class="form-control" name="input_mail" 
                                       id="input_mail" placeholder="Email" 
                                       value="<?= $r->email ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_type" class="col-lg-2 control-label">Type</label>
                            <div class="col-lg-10">			
                                <select class="form-control" name="input_type">
                                    <option value="LAW" <?php if ($r->type == 'LAW') echo 'selected'; ?>>Avocat      </option> 
                                    <option value="SUP" <?php if ($r->type == 'SUP') echo 'selected'; ?>>Support     </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Modifier Contact</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
<?php if (isset($_GET['updsuccess'])) { ?>
        $(window).load(function () {
            alert('Contact modifié avec succès');
        });
<?php } ?>
</script>
</body>
