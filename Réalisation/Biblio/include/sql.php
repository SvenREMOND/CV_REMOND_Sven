<?php


include('./include/connexion.php');

/* Requete pour tout les auteurs */

function sql_auteurs(){
    $pdo = connexion();
    $sql = 'SELECT * FROM auteurs';
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


/* Requete pour un auteur */

function sql_auteur($id){
    $pdo = connexion();
    $sql = 'SELECT * FROM auteurs WHERE id_au = '.$id.'';
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result;
}





/* Requete pour tout les livres */

function sql_livres(){
    $pdo = connexion();
    $sql = 'SELECT * FROM livres';
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


/* Requete pour un auteur */
    /* Pour l'auteur */
    function sql_livre($id){
        $pdo = connexion();
        $sql = 'SELECT titre_livre, img_livre, isbn, prix_livre, resume_livre, livres.id_au, nom_au, prenom_au,auteurs.id_ed, nom_ed FROM livres INNER JOIN auteurs ON livres.id_au = auteurs.id_au INNER JOIN Editeurs ON auteurs.id_ed = editeurs.id_ed WHERE id_livre = '.$id.'';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    /* Pour les livres de l'editeur */
    function sql_livre_auteur($id){
        $pdo = connexion();
        $sql = 'SELECT id_livre, titre_livre, img_livre FROM auteurs INNER JOIN livres ON auteurs.id_au = livres.id_au WHERE auteurs.id_au = '.$id.'';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }





/* Requete pour tout les editeurs */

function sql_editeurs(){
    $pdo = connexion();
    $sql = 'SELECT * FROM editeurs';
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


/* Requete pour un editeur */
    /* Pour l'editeur */
    function sql_editeur($id){
        $pdo = connexion();
        $sql = 'SELECT id_ed, img_ed, nom_ed, adresse_ed FROM editeurs WHERE id_ed = '.$id.'';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    /* Pour les livres de l'editeur */
    function sql_livre_editeur($id){
        $pdo = connexion();
        $sql = 'SELECT id_livre, titre_livre, img_livre FROM editeurs INNER JOIN auteurs ON editeurs.id_ed = auteurs.id_ed INNER JOIN livres ON auteurs.id_au = livres.id_au WHERE editeurs.id_ed = '.$id.'';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    



    /* Pour la recherche */
    function sql_recherche_editeur($q){
        $pdo = connexion();
            $sql = ' SELECT DISTINCT editeurs.*
                    FROM editeurs
                    INNER JOIN auteurs ON editeurs.id_ed = auteurs.id_ed
                    INNER JOIN livres ON auteurs.id_au = livres.id_au
                    WHERE editeurs.nom_ed LIKE "%'.$q.'%" OR 
                        auteurs.nom_au LIKE "%'.$q.'%" OR 
                        auteurs.prenom_au LIKE "%'.$q.'%" OR
                        livres.titre_livre LIKE "%'.$q.'%" ';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function sql_recherche_auteur($q){
        $pdo = connexion();
            $sql = ' SELECT DISTINCT auteurs.*
                    FROM auteurs
                    INNER JOIN editeurs ON auteurs.id_ed = editeurs.id_ed
                    INNER JOIN livres ON auteurs.id_au = livres.id_au
                    WHERE editeurs.nom_ed LIKE "%'.$q.'%" OR 
                        auteurs.nom_au LIKE "%'.$q.'%" OR 
                        auteurs.prenom_au LIKE "%'.$q.'%" OR
                        livres.titre_livre LIKE "%'.$q.'%" ';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function sql_recherche_livre($q){
        $pdo = connexion();
            $sql = ' SELECT DISTINCT livres.*
                    FROM livres 
                    INNER JOIN auteurs ON livres.id_au = auteurs.id_au
                    INNER JOIN editeurs ON auteurs.id_ed = editeurs.id_ed
                    WHERE editeurs.nom_ed LIKE "%'.$q.'%" OR 
                        auteurs.nom_au LIKE "%'.$q.'%" OR 
                        auteurs.prenom_au LIKE "%'.$q.'%" OR
                        livres.titre_livre LIKE "%'.$q.'%"';
        
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


/* Requete pour formulaire */
    /* Pour les auteurs */
    function option_auteur(){
        $pdo = connexion();
        $sql = 'SELECT id_au, nom_au, prenom_au FROM auteurs';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /* Pour les editeurs */
    function option_editeurs(){
        $pdo = connexion();
        $sql = 'SELECT id_ed, nom_ed FROM editeurs';
        $query = $pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
?>


