<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$decaisse = getOneDecaisseById($db, $_GET['id']);
//var_dump($decaisse);die;
?>

<div class="container" style="font-size: 8px!important;">
    <h1>Gestion Décaissés</h1>
    <form class="form-horizontal" method="POST" action="../functions/upd_decaisse.php" id="form_decaisse">
        <input type="hidden" name="input_id" value="<?= $decaisse->ID ?>"/>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_fournisseur" class="col-lg-3 control-label">Fournisseur</label>
                            <div class="col-lg-9">
                                <?php $r_fourns = getAllFourns($db); ?>
                                <select class="form-control" name="input_fournisseur" 
                                        id="input_fournisseur">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_fourns as $r_fourn) :
                                        ?>
                                        <option value="<?= $r_fourn->id; ?>"
                                                <?php if ($decaisse->FOURNISSEUR == $r_fourn->id) echo 'selected'; ?>><?= $r_fourn->nom; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_compta" class="col-lg-3 control-label">Date Compta</label>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" 
                                       name="input_date_compta" 
                                       id="input_date_compta"
                                       value="<?= $decaisse->DATE_COMPTA ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_mode_paiement" class="col-lg-3 control-label">Mode paiement</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="input_mode_paiement" >
                                    <option value=""         <?php if ($decaisse->MODE_PAIEMENT == '') echo 'selected'; ?>>        </option>
                                    <option value="CB"       <?php if ($decaisse->MODE_PAIEMENT == 'CB') echo 'selected'; ?>>CB      </option>
                                    <option value="CHEQUE"   <?php if ($decaisse->MODE_PAIEMENT == 'CHEQUE') echo 'selected'; ?>>CHEQUE  </option>
                                    <option value="LIQUIDE"  <?php if ($decaisse->MODE_PAIEMENT == 'LIQUIDE') echo 'selected'; ?>>LIQUIDE </option>
                                    <option value="MANDAT"   <?php if ($decaisse->MODE_PAIEMENT == 'MANDAT') echo 'selected'; ?>>MANDAT  </option>
                                    <option value="TIP"      <?php if ($decaisse->MODE_PAIEMENT == 'TIP') echo 'selected'; ?>>TIP     </option>
                                    <option value="VIREMENT" <?php if ($decaisse->MODE_PAIEMENT == 'VIREMENT') echo 'selected'; ?>>VIREMENT</option>
                                    <option value="AUTRE"    <?php if ($decaisse->MODE_PAIEMENT == 'AUTRE') echo 'selected'; ?>>AUTRE   </option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_ref_fac" class="col-lg-3 control-label">Ref. Fact.</label>
                            <div class="col-lg-9">
                                <input class="form-control" id="input_ref_fac" name="input_ref_fac" 
                                       placeholder="Référence Facture" type="text"
                                       value="<?= $decaisse->REF_FACTURE ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_paiement" class="col-lg-3 control-label">Date Paiement</label>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" 
                                       name="input_date_paiement" 
                                       id="input_date_paiement"
                                       value="<?= $decaisse->DATE_PAIEMENT ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ref_pai" class="col-lg-3 control-label">Ref Paiement</label>
                            <div class="col-lg-9">
                                <input class="form-control" id="input_ref_pai" name="input_ref_pai" 
                                       placeholder="Référence Paiement" type="text"
                                       value="<?= $decaisse->REF_PAIEMENT ?>"/>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <fieldset>
                <?php
                $dd = getAllDDByDecaisseId($db, $decaisse->ID);
                ?>
                <div class="form-group">
                    <label for="input_line1" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line1" id="input_line1"
                               <?php if (isset($dd[0])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line1_ht" 
                               id="input_line1_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[0]->HT_AMOUNT) ? $dd[0]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line1_percent" 
                               id="input_line1_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[0]->TVA_PERCENT) ? $dd[0]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line1_tva" 
                               id="input_line1_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[0]->TVA_AMOUNT) ? $dd[0]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line1_ttc" 
                               id="input_line1_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[0]->TTC_AMOUNT) ? $dd[0]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_line2" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line2" id="input_line2"
                               <?php if (isset($dd[1])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line2_ht" 
                               id="input_line2_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[1]->HT_AMOUNT) ? $dd[1]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line2_percent" 
                               id="input_line2_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[1]->TVA_PERCENT) ? $dd[1]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line2_tva" 
                               id="input_line2_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[1]->TVA_AMOUNT) ? $dd[1]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line2_ttc" 
                               id="input_line2_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[1]->TTC_AMOUNT) ? $dd[1]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_line3" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line3" id="input_line3"
                               <?php if (isset($dd[2])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line3_ht" 
                               id="input_line3_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[2]->HT_AMOUNT) ? $dd[2]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line3_percent" 
                               id="input_line3_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[2]->TVA_PERCENT) ? $dd[2]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line3_tva" 
                               id="input_line3_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[2]->TVA_AMOUNT) ? $dd[2]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line3_ttc" 
                               id="input_line3_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[2]->TTC_AMOUNT) ? $dd[2]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_line4" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line4" id="input_line4"
                               <?php if (isset($dd[3])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line4_ht" 
                               id="input_line4_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[3]->HT_AMOUNT) ? $dd[3]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line4_percent" 
                               id="input_line4_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[3]->TVA_PERCENT) ? $dd[3]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line4_tva" 
                               id="input_line4_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[3]->TVA_AMOUNT) ? $dd[3]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line4_ttc" 
                               id="input_line4_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[3]->TTC_AMOUNT) ? $dd[3]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_line4" class="col-lg-2 control-label">
                        Total
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_amount_lines_ht" 
                               id="input_amount_lines_ht" 
                               value="<?= $decaisse->DEC_HT_TOT_AMOUNT ?>"
                               placeholder="Total HT" />
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_amount_lines_tva" 
                               id="input_amount_lines_tva"  
                               value="<?= $decaisse->DEC_TVA_TOT_AMOUNT ?>"
                               placeholder="Total Tva" />
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_amount_lines_ttc" 
                               id="input_amount_lines_ttc"  
                               value="<?= $decaisse->DEC_TTC_TOT_AMOUNT ?>"
                               placeholder="Total TTC" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_description" class="col-lg-1 control-label">Description</label>
                    <div class="col-lg-10">
                        <textarea class="form-control" name="input_description" placeholder="Description"><?= $decaisse->DESCRIPTION ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
<script type="text/javascript">
<?php if (isset($_GET['success']) && $_GET['success'] == 'upd') { ?>
        $(window).load(function () {
            alert('Facture modifiée avec succès');
        });
<?php } ?>
</script>