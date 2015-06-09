<?php

function getAllContact($db)
{
    $sql = "SELECT id, civilite, nom, prenom, tel, fonction, type, email "
            . "FROM contact "
            . "ORDER BY nom ";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function getContactByClientId($db, $type, $id)
{
    $sql = "SELECT ID, civilite, nom, prenom, tel, fonction, type, email "
            . "FROM contact "
            . "WHERE client = '".$id."' and type = '".$type."' and ifnull(inactif, 'N') <> 'Y' "
            . "ORDER BY nom ";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function getOneContactByClientIdType($db, $type, $id)
{
        $sql = "SELECT ID, civilite, nom, prenom, tel, fonction, type, email "
            . "FROM contact "
            . "WHERE client='".$id."' and type='".$type."' and ifnull(inactif, 'N') <> 'Y' "
            . "ORDER BY nom ";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function getOneContactById($db, $id)
{
    $sql = "SELECT ID, client, civilite, inactif, nom, prenom, tel, fonction, type, "
        . "email, remarque "
        . "FROM contact "
        . "WHERE id='".$id."'";

    $r_contact= $db->prepare($sql);
    $r_contact->execute();
    $r = $r_contact->fetch(PDO::FETCH_OBJ);
    return $r;
}


?>