<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

if (!($_SESSION['user']['type'] == "ADMIN" || $_SESSION['user']['type'] == "SUPERADMIN")) {
    ?>
    <script type="text/javascript">
        top.location.replace('../index.php');
    </script>
    <?php
}
?>
<div class="container">
    <h1>Gestion Notes de Frais</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="search">
            <form class="form-horizontal" method="GET" action="ndf.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_month" class="col-lg-3 control-label">Mois</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="input_month" 
                                                id="input_month">
                                            <option value=""></option>
                                            <option value="janvier" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'janvier') echo "selected";?>>Janvier</option>
                                            <option value="février" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'février') echo "selected";?>>Février</option>
                                            <option value="mars" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'mars') echo "selected";?>>Mars</option>
                                            <option value="avril" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'avril') echo "selected";?>>Avril</option>
                                            <option value="mai" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'mai') echo "selected";?>>Mai</option>
                                            <option value="juin" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'juin') echo "selected";?>>Juin</option>
                                            <option value="juillet" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'juillet') echo "selected";?>>Juillet</option>
                                            <option value="août" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'août') echo "selected";?>>Août</option>
                                            <option value="septembre" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'septembre') echo "selected";?>>Septembre</option>
                                            <option value="octobre" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'octobre') echo "selected";?>>Octobre</option>
                                            <option value="novembre" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'novembre') echo "selected";?>>Novembre</option>
                                            <option value="décembre" <?php if(isset($_GET['input_month']) && $_GET['input_month'] == 'décembre') echo "selected";?>>Décembre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-9">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_year" class="col-lg-3 control-label">Année</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="input_year" 
                                                id="input_year">
                                            <option value=""></option>
                                            <?php 
                                            for($i=2002 ; $i<=date('Y') ; $i++):
                                            ?>
                                                <option value="<?= $i ?>" 
                                                    <?php 
                                                    if(isset($_GET['input_year']) && $_GET['input_year'] == $i){echo "selected";}
                                                    elseif(!isset($_GET['input_year']) && date('Y') == $i){echo "selected";}
                                                    ?>><?= $i ?></option>
                                            <?php
                                            endfor;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <?php
                if (!empty($_GET)) {
                    $r_ndfs = searchNdf($db);

                    if ($r_ndfs) {
                        //var_dump($r_ndfs);die;
                        ?>
                        
                        <h1>Résultats - <?= count($r_ndfs) ?> notes de frais</h1>
                        <div class="jumbotron">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Description</th>
                                        <th>HT</th>
                                        <th>TVA</th>
                                        <th>TTC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_ht_ndf = 0;
                                    $total_tva_ndf = 0;
                                    $total_ttc_ndf = 0;
                                    foreach ($r_ndfs as $r_ndfs) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="./upd_ndf.php?id=<?= $r_ndfs->id ?>">
                                                    <?= $r_ndfs->id ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?= $r_ndfs->description ?>
                                            </td>
                                            <td>
                                                <?= $r_ndfs->ht_tot_amount ?>
                                            </td>
                                            <td>
                                                <?= $r_ndfs->tva_tot_amount ?>
                                            </td>
                                            <td>
                                                <?= $r_ndfs->ttc_tot_amount ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $total_ht_ndf += $r_ndfs->ht_tot_amount;
                                        $total_tva_ndf += $r_ndfs->tva_tot_amount;
                                        $total_ttc_ndf += $r_ndfs->ttc_tot_amount;
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
                    <h1>Bilan</h1>
                    <div class="">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        Total HT
                                    </td>
                                    <td>
                                        <?= isset($total_ht_ndf) ? $total_ht_ndf : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Total TVA
                                    </td>
                                    <td>
                                        <?= isset($total_tva_ndf) ? $total_tva_ndf : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Total TTC
                                    </td>
                                    <td>
                                        <?= isset($total_ttc_ndf) ? $total_ttc_ndf : '' ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </form>
        </div>
        <div class="tab-pane fade" id="add">
            <form class="form-horizontal" method="POST" action="../functions/new_ndf.php" id="form_decaisse">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_month" class="col-lg-3 control-label">Mois</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="input_month" 
                                                id="input_month">
                                            <option value=""></option>
                                            <option value="janvier">Janvier</option>
                                            <option value="février">Février</option>
                                            <option value="mars">Mars</option>
                                            <option value="avril">Avril</option>
                                            <option value="mai">Mai</option>
                                            <option value="juin">Juin</option>
                                            <option value="juillet">Juillet</option>
                                            <option value="août">Août</option>
                                            <option value="septembre">Septembre</option>
                                            <option value="octobre">Octobre</option>
                                            <option value="novembre">Novembre</option>
                                            <option value="décembre">Décembre</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_year" class="col-lg-3 control-label">Année</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="input_year" 
                                                id="input_year">
                                            <option value=""></option>
                                            <?php 
                                            for($i=2002 ; $i<=date('Y') ; $i++):
                                            ?>
                                                <option value="<?= $i ?>" ><?= $i ?></option>
                                            <?php
                                            endfor;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <fieldset>

                        <div class="form-group">
                            <label for="input_line1" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line1" /> 20%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line1_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line1_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line1_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_line2" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line2" /> 10%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line2_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line2_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line2_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_line3" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line3" /> 5,5%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line3_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line3_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line3_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_line4" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line4" /> 0%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line4_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line4_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line4_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_description" class="col-lg-1 control-label">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="input_description" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>