<?php

include("./include/sql.php");
include('./include/Page/page.php');

    /* Index */
    function index(){
        Doctype_header_nav("./controleur.php");

        echo '<main>';

        echo '<form action="./controleur.php?action=search" method="POST" class="index">
                    <input id="S" type="search" name="q" placeholder="Votre Recherche" autocomplete="off" />
                    <label for="OK"><i class="fas fa-search"></i></label>
                    <input id="OK" type="submit" value="OK" name="submit" />
                </form>

                <div class="conteneur">
                    <a href="./controleur.php?action=livres">
                        <div class="index_livre">
                            <p>Livres</p>
                        </div>
                    </a>
                    <a href="./controleur.php?action=auteurs">
                        <div class="index_auteur">
                            <p>Auteurs</p>
                        </div>
                    </a>
                    <a href="./controleur.php?action=editeurs">
                        <div class="index_editeur">
                            <p>Editeurs</p>
                        </div>
                    </a>
                </div>';

        echo '</main>';

        footer("./controleur.php");
    }

    /* 404 */
    function erreur_page(){
        Doctype_header_nav("./controleur.php");

        echo '<main>
                <div class="conteneur">
                    <h1>Page introuvable</h1>
                </div>
            </main>';

        footer("./controleur.php");
    }


    /* Affichage de la liste des livres */
    function liste_livre(){
        Doctype_header_nav("./controleur.php?action=livres");

        echo '<main>';

        $result = sql_livres();
        foreach($result as $re){
            echo '<a href="./controleur.php?action=livre&id='.$re['id_livre'].'">
                    <div class="conteneur_livres">
                        <div class="image_livres">
                            <img src="'.$re['img_livre'].'">
                        </div>
                        <div class="info_livres">
                            <h1>'.$re['titre_livre'].'</h1>
                            <p class="prix">Prix : '.$re['prix_livre'].' €</i></p>
                        </div>
                    </div>
                </a>';
        }

        echo '</main>';

        footer();        
    }


    /* Affichage d'un livre */
    function affich_livre($id){
        Doctype_header_nav("./controleur.php?action=livre");

        echo '<main>';

        $result = sql_livre($id);
            echo '<div class="conteneur_livre">
                    <div class="image_livre"><img src="'.$result['img_livre'].'"></div>
                        <div class="info_livre">
                            <h1 class="titre_livre">'.$result['titre_livre'].'</h1>
                            <p class="prix_isbn">Prix : '.$result['prix_livre'].' €<br>isbn : '.$result['isbn'].'</p>
                            <p class="resume">Résumé : '.$result['resume_livre'].'</p>
                            <p class="auteur_editeur_livre">Auteur : <a class="au_ed" href="./controleur.php?action=auteur&id='.$result['id_au'].'">'.$result['prenom_au'].' '.$result['nom_au'].'</a><br>Editeurs : <a class="au_ed" href="./controleur.php?action=editeur&id='.$result['id_ed'].'">'.$result['nom_ed'].'</a></p>
                            <p class="modif_suppr"><a class="modif" href="./controleur.php?action=updatelivre&id='.$id.'">Modifier</a> || <a class="suppr" href="./controleur.php?action=supprlivre&id='.$id.'">Supprimer</a></p>
                        </div>
                    </div>';
        

        echo '</main>';

        footer("./controleur.php?action=livre");
    }
        
    





    /* Affichage de la liste des Auteurs */
    function liste_auteur(){
        Doctype_header_nav("./controleur.php?action=auteurs");

        echo '<main>';

        $result = sql_auteurs();
        foreach($result as $re){
            echo '<a class="auteur" href="./controleur.php?action=auteur&id='.$re['id_au'].'"><div class="conteneur_auteurs">
                    <div class="image_auteurs">
                        <img src="'.$re['img_au'].'">
                    </div>
                    <div class="info_auteur">
                        <h1>'.$re['prenom_au'].' '.$re['nom_au'].'</h1>
                    </div>
                </div></a>';
        }

        echo '</main>';

        footer();
    }

    /* Affichage d'un auteur */
    
    function affich_auteur($id){
        Doctype_header_nav("./controleur.php?action=auteur");

        echo '<main>';

        $result = sql_auteur($id);
            echo '<div class="conteneur_tout_auteur">
                        <div class="conteneur_image_info">
                            <div class="image_auteur"><img src="'.$result['img_au'].'"></div>
                            <div class="info_auteur">
                                <h1 class="nom_auteur">'.$result['prenom_au'].' '.$result['nom_au'].'</h1>
                                <p>Date de naissance : '.$result['naissance_au'].'</p>
                                <p class="modif_suppr"><a class="modif" href="./controleur.php?action=updateauteur&id='.$id.'">Modifier</a> || <a class="suppr" href="./controleur.php?action=supprauteur&id='.$id.'">Supprimer</a></p>
                            </div>
                        </div><p class="biographie">Biographie : '.$result['bio_au'].'</p>
                        ';
        
        $result = sql_livre_auteur($id);
        echo '<div class="conteneur_livres_dauteur">';
        foreach($result as $re){
            echo '<a href="./controleur.php?action=livre&id='.$re['id_livre'].'">
                        <div class="livres_auteur">
                            <div class="image_livre_auteur">
                                <img src="'.$re['img_livre'].'">
                            </div>
                            <div class="info_livres">
                                <h1>'.$re['titre_livre'].'</h1>
                            </div>
                        </div>
                    </a>';
        }
        echo '</div>';

        echo '</main>';

        footer();
    }

    




    /* Affichage des éditeurs */
    function liste_editeurs(){
        Doctype_header_nav("./controleur.php?action=editeurs");
        
        echo '<main>';

        $result = sql_editeurs();
        foreach($result as $re){
            echo '<a href="./controleur.php?action=editeur&id='.$re['id_ed'].'">
                    <div class="conteneur_editeurs">
                        <div class="image_editeurs">
                            <img src="'.$re['img_ed'].'">
                        </div>
                        <div class="info_editeur">
                            <h1>'.$re['nom_ed'].'</h1>
                        </div>
                    </div>
                </a>';
        }

        echo '</main>';

        footer();
    }


    /* Affichage d'un éditeur */
    function affich_editeur($id){
        Doctype_header_nav("./controleur.php?action=editeur");

        echo '<main>';

        $result = sql_editeur($id);
            echo '<div class="conteneur_tout_editeur">
                        <div class="conteneur_image_info">
                            <div class="image_editeur"><img src="'.$result['img_ed'].'"></div>
                            <div class="info_editeur">
                                <h1 class="nom_editeur">'.$result['nom_ed'].'</h1>
                                <p>Adresse : '.$result['adresse_ed'].'</p>
                                <p class="modif_suppr"><a class="modif" href="./controleur.php?action=updateediteur&id='.$id.'">Modifier</a> || <a class="suppr" href="./controleur.php?action=supprediteur&id='.$id.'">Supprimer</a></p>
                            </div>
                        </div>';
        $result = sql_livre_editeur($id);
        echo '<div class="conteneur_livres_dediteur">';
        foreach($result as $re){
            echo '<a href="./controleur.php?action=livre&id='.$re['id_livre'].'">
                        <div class="livres_editeur">
                            <div class="image_livre_editeur">
                                <img src="'.$re['img_livre'].'">
                            </div>
                            <div class="info_livres">
                                <h1>'.$re['titre_livre'].'</h1>
                            </div>
                        </div>
                    </a>';
        }
        echo '</div>';

        echo '</main>';

        footer();        
    }
    

    

    /* Affichage recherche */
    function affich_recherche_editeur($q){
        $result = sql_recherche_editeur($q);
        $isEmpty  = ( empty(array_filter($result, function($value, $key){ return $value != ""; },ARRAY_FILTER_USE_BOTH)) ) ? false : true;
        if($isEmpty){
            echo '<h2>Les éditeurs :</h2>';
            foreach($result as $re){
                echo '<a href="./controleur.php?action=editeur&id='.$re['id_ed'].'">
                        <div class="conteneur_editeurs">
                            <div class="image_editeurs">
                                <img src="'.$re['img_ed'].'">
                            </div>
                            <div class="info_editeur">
                                <h1>'.$re['nom_ed'].'</h1>
                            </div>
                        </div>
                    </a>';
            }
        }
    }
    function affich_recherche_auteur($q){
        $result = sql_recherche_auteur($q);
        $isEmpty  = ( empty(array_filter($result, function($value, $key){ return $value != ""; },ARRAY_FILTER_USE_BOTH)) ) ? false : true;
        if($isEmpty){
            echo '<h2>Les auteurs :</h2>';
            foreach($result as $re){
                echo '<a class="auteur" href="./controleur.php?action=auteur&id='.$re['id_au'].'"><div class="conteneur_auteurs">
                        <div class="image_auteurs">
                            <img src="'.$re['img_au'].'">
                        </div>
                        <div class="info_auteur">
                            <h1>'.$re['prenom_au'].' '.$re['nom_au'].'</h1>
                        </div>
                        </div></a>';
            }
        }
    }
    function affich_recherche_livre($q){
        $result = sql_recherche_livre($q);
        $isEmpty  = ( empty(array_filter($result, function($value, $key){ return $value != ""; },ARRAY_FILTER_USE_BOTH)) ) ? false : true;
        if($isEmpty){
            echo '<h2>Les livres :</h2>';
            foreach($result as $re){
                echo '<a href="./controleur.php?action=livre&id='.$re['id_livre'].'">
                        <div class="conteneur_livres">
                            <div class="image_livres">
                                <img src="'.$re['img_livre'].'">
                            </div>
                            <div class="info_livres">
                                <h1>'.$re['titre_livre'].'</h1>
                                <p class="prix">Prix : '.$re['prix_livre'].' €</i></p>
                            </div>
                        </div>
                    </a>';
            }
        }
    }
    function affich_recherche($q){
        Doctype_header_nav();

        echo '<main>';

        echo '<h1>Voici ce qu\'il y a en lien avec votre recherche :</h1>
                <p class="notre_recherche">qui est : <i>'.$q.'</i></p>';
        affich_recherche_livre($q);
        affich_recherche_auteur($q);
        affich_recherche_editeur($q);

        echo '</main>';

        footer();
    }





/* Formulaire */

    /* Affichage liste option auteur */
    function liste_option_auteur($selected){
        $result = option_auteur();
        foreach($result as $re){
            if($selected == $re['id_au']){
                echo '<option selected value="'.$re['id_au'].'">'.$re['nom_au'].' '.$re['prenom_au'].'</option>';
            }else{
                echo '<option value="'.$re['id_au'].'">'.$re['nom_au'].' '.$re['prenom_au'].'</option>';
            }
        }
    }

    /* Affichage liste option editeur */
    function liste_option_editeur($selected){
        $result = option_editeurs();
        foreach($result as $re){
            if($selected == $re['id_ed']){
                echo '<option selected value="'.$re['id_ed'].'">'.$re['nom_ed'].'</option>';
            }else{
                echo '<option value="'.$re['id_ed'].'">'.$re['nom_ed'].'</option>';
            }
        }
    }



?>