<?php

    include('./include/affichage.php');
    include('./include/ajout_modif.php');

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }else{
        $action = "index";
    }
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
    }else{
        $id = "";
    }


    switch($action){

        default :
            erreur_page();
        break;

        case 'index' :
            index();
        break;

        case 'editeurs' :
            liste_editeurs();
        break;

        case 'editeur' :
            affich_editeur($id);
        break;

        case 'updateediteur' :
            modif_editeur($id);
        break;

        case 'auteurs' :
            liste_auteur();
        break;

        case 'auteur' :
            affich_auteur($id);
        break;

        case 'updateauteur' :
            modif_auteur($id);
        break;

        case 'livres' :
            liste_livre();
        break;

        case 'livre' :
            affich_livre($id);
        break;

        case 'updatelivre' :
            modif_livre($id);
        break;

        case 'search' :
            affich_recherche($_POST['q']);
        break;

        case 'newauteur' :
            ajout_auteur();
        break;

        case 'newediteur' :
            ajout_editeur();
        break;

        case 'newlivre' :
            ajout_livre();
        break;

        case 'supprlivre' :
            suppr_livre($id);
        break;

        case 'supprauteur' :
            suppr_auteur($id);
        break;

        case 'supprediteur' :
            suppr_editeur($id);
        break;
    }




?>