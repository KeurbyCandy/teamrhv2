<?php

function getAllSpec($db)
{
    $sql = "SELECT id, libelle "
            . "FROM specialite";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

function getAllSpecByEval($db, $id)
{
    $sql = "SELECT es.id_eval, es.id_spec, s.libelle, s.id "
            . "FROM eval_spec es "
            . "LEFT JOIN specialite s ON s.id = es.id_spec "
            . "WHERE es.ID_EVAL='".$id."'";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}
?>