<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>
<div class="container-fluid">
    <h1>Gestion des postes</h1>
    <ul class="nav nav-tabs">
        <li <?= (isset($_GET['tab']) && $_GET['tab'] == "search") || isset($_GET['tab']) ? '' : 'class="active"' ?>><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li <?= isset($_GET['tab']) && $_GET['tab'] == "new" ? 'class="active"' : '' ?>><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade <?= isset($_GET['tab']) && $_GET['tab'] == "new" ? "" : "active in" ?>" id="search">
            <form class="form-horizontal" method="GET" action="job.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-2 control-label">Libellé</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : ""; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contact" class="col-lg-2 control-label">Consultant</label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllImportantUsers($db); ?>
                                        <select class="form-control" name="input_contact" id="input_contact">
                                            <option value=""></option>
                                            <?php
                                            while ($user_r = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $user_r->id; ?>" <?php if (isset($_GET['input_contact']) && $_GET['input_contact'] == $user_r->id) echo "selected"; ?>><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_customer" class="col-lg-2 control-label">Client</label>
                                    <div class="col-lg-10">
                                        <select class="select2-container select2-container-multi form-control" 
                                                name="input_customer" id="input_customer" 
                                                style="width:100%">
                                                    <?php if (isset($_GET['input_customer'])) { ?>
                                                        <?php $r_client = getOneCustomerById($db, $_GET['input_customer']); ?>
                                                <option value="<?= $r_client->id ?>"><?= $r_client->nom ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_pourvu" class="col-lg-2 control-label">Statut</label>
                                    <div class="col-lg-10">
                                        <select name="input_pourvu" id="input_pourvu" class="form-control">
                                            <option value="" <?php if (isset($_GET['input_pourvu']) && $_GET['input_pourvu'] == '') echo 'selected'; ?>></option>
                                            <option value="Y" <?php if (isset($_GET['input_pourvu']) && $_GET['input_pourvu'] == 'Y') echo 'selected'; ?>>Poste Fermé</option>
                                            <option value="N" <?php if (isset($_GET['input_pourvu']) && $_GET['input_pourvu'] == 'N') echo 'selected'; ?>>Poste Ouvert</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>

            <?php
            if (!empty($_GET) && !array_key_exists('tab', $_GET)) {
                $r_jobs = searchJobs($db);
                $result_search = $r_jobs->fetchAll(PDO::FETCH_OBJ);
                if ($result_search) {
                    ?>

                    <h1>Résultats - <?= count($result_search) ?> postes</h1>
                    <div class="jumbotron">
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th class="col-lg-1">N°</th>
                                    <th class="col-lg-2">Client</th>
                                    <th class="col-lg-3">Libelle</th>
                                    <th class="col-lg-3">Titre</th>
                                    <th class="col-lg-1 text-right">Cons.</th>
                                    <th class="col-lg-1 text-right">Comm</th>
                                    <th class="col-lg-1 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result_search as $r_job) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="upd_job.php?id=<?= isset($r_job->id) ? $r_job->id : ''; ?>">
                                                <?= $r_job->id ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="upd_client.php?id=<?= isset($r_job->client) ? $r_job->client : ''; ?>">
                                                <?= isset($r_job->nom) ? $r_job->nom : '' ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?= isset($r_job->libelle) ? $r_job->libelle : ''; ?>
                                        </td>
                                        <td>
                                            <?= isset($r_job->titre) ? $r_job->titre : ''; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php $r_user = getUserById($db, $r_job->consultant); ?>
                                            <?php
                                            if ($r_user)
                                                echo $r_user->initiale;
                                            ?>
                                        </td>
                                        <td class="text-right">
                                            <?= isset($r_job->comm) ? $r_job->comm : ''; ?>
                                        </td>
                                        <td class="text-right">
                                            <a href="del_client.php?id=<?= isset($r_job->client) ? $r_job->client : ''; ?>" onclick="return confirm('Pas disponible pour le moment.')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4>Attention!</h4>
                        <p>Aucun résultats</p>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="tab-pane fade <?= isset($_GET['tab']) ? "active in" : "" ?>" id="add">
            <form class="form-horizontal" method="POST" action="../functions/new_job.php" id="form_job">
                <div class="row">
                    <div class="col-md-6">
                        <div class="jumbotron">
                            <div class="form-group">
                                <label for="input_description" class="col-lg-1 control-label">Description</label>
                                <div class="col-lg-11">
                                    <textarea class="form-control" id="input_description" 
                                              name="input_description" placeholder="Description" type="text" rows="15"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="jumbotron">
                            <div class="form-group">
                                <label for="input_description" class="col-lg-1 control-label">Comment.</label>
                                <div class="col-lg-11">
                                    <textarea class="form-control" id="input_commentaire"
                                              name="input_commentaire" placeholder="Commentaire" 
                                              type="text" rows="20"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-10">
                                <h1>Fiche poste</h1>
                            </div>
                            <div class="col-lg-2">
                                <h1 class="pull-right"><button type = "submit" class = "btn btn-primary">Enregistrer</button></h1>
                            </div>
                        </div>
                        <div class="jumbotron">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="input_name" class="col-lg-2 control-label"><b>Libelle*</b></label>
                                            <div class="col-lg-10">
                                                <input class="form-control" id="input_name" 
                                                       name="input_name" required
                                                       placeholder="Nom" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_title" class="col-lg-2 control-label">Titre</label>
                                            <div class="col-lg-10">
                                                <?php $r_titles = getAllTitles($db); ?>
                                                <select class="form-control" name="input_title" id="input_title">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($r_titles as $r_title):
                                                        ?>
                                                        <option value="<?= $r_title->id ?>"><?= $r_title->libelle ?></option>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_customer" class="col-lg-2 control-label">
                                                Client*
                                            </label>
                                            <div class="col-lg-10">
                                                <select class="select2-container form-control select2  select2-container--bootstrap" 
                                                        id="input_customer_select" required
                                                        name="input_customer" style="width:100%;">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_signature" class="col-lg-4 control-label">Date de miss.</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" id="input_signature" 
                                                       name="input_signature" type="date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_exp" class="col-lg-2 control-label">Expérience</label>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="input_exp" id="input_exp">
                                                    <option value=""></option>
                                                    <option value="Aucune">Aucune</option>
                                                    <option value="< 1 an">< 1 an</option>
                                                    <option value="1 à 3 ans">1 à 3 ans</option>
                                                    <option value="4 à 5 ans">4 à 5 ans</option>
                                                    <option value="6 à 10 ans">6 à 10 ans</option>
                                                    <option value="> 10 ans">> 10 ans</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="input_communication" class="col-lg-2 control-label">Com.</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="input_communication" id="input_communication">
                                                    <option value=""></option>
                                                    <option value="N">N</option>
                                                    <option value="Y">Y</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_pourvu" class="col-lg-2 control-label">Statut*</label>
                                            <div class="col-lg-10">
                                                <select name="input_pourvu" required
                                                        id="input_pourvu" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Y">Poste Fermé</option>
                                                    <option value="N">Poste Ouvert</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_contact" class="col-lg-2 control-label">Consultant*</label>
                                            <div class="col-lg-10">
                                                <?php $r_users = getAllUsers($db); ?>
                                                <select class="form-control" required
                                                        name="input_contact" id="input_contact">
                                                    <option value=""></option>
                                                    <?php
                                                    while ($user_r = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <option value="<?php echo $user_r->id; ?>"><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_starting_date" class="col-lg-3 control-label">Date de deb.</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" id="input_starting_date" 
                                                       name="input_starting_date" type="date" 
                                                       >
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="jumbotron">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="input_percent" class="col-lg-2 control-label">Pourcent.</label>
                                            <div class="col-lg-10">
                                                <input class="form-control" id="input_percent" 
                                                       name="input_percent" placeholder="Pourcentage" 
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_forfait" class="col-lg-2 control-label">Forfait</label>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-4" id="input_forfait" 
                                                       name="input_forfait" placeholder="Forfait" 
                                                       type="text">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="input_garantie" class="col-lg-2 control-label">Garantie</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="input_garantie" 
                                                        id="input_garantie">
                                                    <option value=""></option>
                                                    <option value="2 semaines">2 semaines</option>
                                                    <option value="3 semaines">3 semaines</option>
                                                    <option value="1 mois">1 mois</option>
                                                    <option value="2 mois">2 mois</option>
                                                    <option value="3 mois">3 mois</option>
                                                    <option value="4 mois">4 mois</option>
                                                    <option value="6 mois">6 mois</option>
                                                    <option value="12 mois">12 mois</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_formule" class="col-lg-2 control-label">Formule</label>
                                            <div class="col-lg-3">
                                                <input class="form-control col-lg-4" id="input_formule" 
                                                       name="input_formule" placeholder="1" 
                                                       type="text">
                                            </div>
                                            <div class="col-lg-3">
                                                <input class="form-control col-lg-4" id="input_formule2" 
                                                       name="input_formule2" placeholder="2" 
                                                       type="text">
                                            </div>
                                            <div class="col-lg-3">
                                                <input class="form-control col-lg-4" id="input_formule3" 
                                                       name="input_formule3" placeholder="3" 
                                                       type="text">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="jumbotron">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="input_contrat" class="col-lg-2 control-label">Contrat</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="input_contrat" id="input_contrat">
                                                    <option value=""></option>
                                                    <option value="Libéral">Libéral</option>
                                                    <option value="CDD">CDD</option>
                                                    <option value="CDI">CDI</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_salary" class="col-lg-2 control-label">Rém.</label>
                                            <div class="col-lg-10">
                                                <input class="form-control" id="input_salary" 
                                                       name="input_salary" placeholder="Salaire" 
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_diplome" class="col-lg-2 control-label">Diplôme</label>
                                            <div class="col-lg-10">
                                                <?php $r_diplomes = getAllDiplomes($db); ?>
                                                <select class="form-control" name="input_diplome" id="input_diplome">
                                                    <option value=""></option>
                                                    <?php
                                                    while ($r_diplome = $r_diplomes->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <option value="<?php echo $r_diplome->id; ?>"><?php echo $r_diplome->libelle; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_speed" class="col-lg-2 control-label">Vitesse</label>
                                            <div class="col-lg-4">
                                                <input class="form-control" id="input_speed" 
                                                       name="input_speed" type="text"
                                                       />
                                            </div>
                                            <label for="input_appli_1" class="col-lg-2 control-label">Autre Appli. 1</label>
                                            <div class="col-lg-4">
                                                <input class="form-control" id="input_appli_1"
                                                       name="input_appli_1" placeholder="Application" 
                                                       type="text"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_fr" class="col-lg-2 control-label">Niveau FR</label>
                                            <div class="col-lg-4">
                                                <input class="form-control" id="input_fr" 
                                                       name="input_fr" placeholder="Niveau francais" 
                                                       type="text">
                                            </div>
                                            <label for="input_an" class="col-lg-2 control-label">Niveau AN</label>
                                            <div class="col-lg-4">
                                                <input class="form-control" id="input_an" 
                                                       name="input_an" placeholder="Niveau anglais" 
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_place" class="col-lg-2 control-label">Lieux</label>
                                            <div class="col-lg-10">
                                                <input class="form-control" id="input_place" 
                                                       name="input_place" placeholder="Lieux" 
                                                       type="text">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="input_period" class="col-lg-2 control-label">Durée</label>
                                            <div class="col-lg-5">
                                                <input class="form-control" id="input_period" 
                                                       name="input_period" placeholder="URL" 
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_schedule" class="col-lg-2 control-label">Horaires</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="input_schedule" id="input_schedule">
                                                    <option value=""></option>
                                                    <option value="matinée">Matinée</option>
                                                    <option value="jour">Jour</option>
                                                    <option value="après-midi">Après-midi</option>
                                                    <option value="soirée">Soirée</option>
                                                    <option value="nuit">Nuit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input_appli_2" class="col-lg-2 control-label">Autre Appli. 2</label>
                                            <div class="col-lg-10">
                                                <input class="form-control" id="input_appli_2" 
                                                       name="input_appli_2" placeholder="Application" 
                                                       type="text">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#input_customer_select').select2({
            ajax: {
                url: "../api/customers.php",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Selectionner un client',
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 2
        });

        $('#input_customer').select2({
            ajax: {
                url: "../api/customers.php",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            allowClear: true,
            placeholder: 'Selectionner un client',
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 2
        });
    });
</script>