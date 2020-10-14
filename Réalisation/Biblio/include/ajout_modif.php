<?php

function verifInput($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    
    return $var;
}

?>

<?php
/* ************ */
/* Ajout auteur */
/* ************ */


function ajout_auteur(){

    
    $nom = $prenom = $bio = $editeur = $naissance = "";
    $nomerr = $prenomerr = $bioerr = $editeurerr = "";


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $nom = verifInput($_POST['nom']);
        $prenom = verifInput($_POST['prenom']);
        $bio = verifInput($_POST['bio']);
        $editeur = verifInput($_POST['editeur']);
        $naissance = verifInput($_POST['naissance']);
        
        if(!empty($nom) && !empty($prenom) && !empty($bio)){

            $emplacement = './image/auteurs/'; // dossier où sera déplacé le fichier

            $image = './image/img_par_defaut.jpg';

            if(!empty($_POST['image_auteur'])){

                $tmp_file = $_FILES['image_auteur']['tmp_name'];
            
                if( is_uploaded_file($tmp_file) ){
        
                    // on vérifie maintenant l'extension
                    $type_file = $_FILES['image_auteur']['type'];
        
                    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') &&!strstr($type_file, 'png')){
                        exit("Le fichier n'est pas une image");
                        }else{
            
                        // on copie le fichier dans le dossier de destination
                        $name_file = $_FILES['image_auteur']['name'];
                        
                        
                        if( !move_uploaded_file($tmp_file, $emplacement . $name_file) ){
                        }else{
                            $newname = preg_replace( "# #", "_", $_POST['nom'])."_".$_POST['prenom'].".jpg";
                            $name = rename( $emplacement.$name_file,  $emplacement.$newname);
                            $image = './image/auteur/'.$newname;

                            $pdo = connexion();

                            $query = $pdo->prepare('INSERT INTO auteurs (nom_au, prenom_au, bio_au, naissance_au, img_au, id_ed) VALUES (?, ?, ?, ?, ?, ?)');
                            $query->execute([$nom, $prenom, $bio, $naissance, $image, $editeur]);
            
                            $newid = $pdo->lastInsertId();
                                
                            header('Location: ./controleur.php?action=auteur&id='.$newid.'');
            
                            die();
        
                        }
                    }
                }
            }else{
                $pdo = connexion();

                $query = $pdo->prepare('INSERT INTO auteurs (nom_au, prenom_au, bio_au, naissance_au, img_au, id_ed) VALUES (?, ?, ?, ?, ?, ?)');
                $query->execute([$nom, $prenom, $bio, $naissance, $image, $editeur]);
        
                $newid = $pdo->lastInsertId();
                            
                header('Location: ./controleur.php?action=auteur&id='.$newid.'');
        
                die();
        
            }
    
        }else{
            if(empty($nom)){
                $nomerr = "Le nom de l'auteur est necessaire!";
            }
            if(empty($prenom)){
                $prenomerr = "Le prenom de l'auteur est necessaire!";
            }
            if(empty($bio)){
                $bioerr = "La biographie de l'auteur est necessaire!";
            }
        }

    }
    Doctype_header_nav();

echo '
        <main class="main_formulaire">

            <form method="POST" class="formulaire" enctype="multipart/form-data">

                <div>
                    <p>
                        <label for="nom">Nom <span class="need">*</span></label>
                        <span class="needmessage">'.$nomerr.'</span>
                    </p>
                    <p>
                        <input type="text" name="nom" value="'.$nom.'">
                    </p>
                </div>

                <div>
                    <p>
                        <label for="prenom">Prenom <span class="need">*</span></label>
                        <span class="needmessage">'.$prenomerr.'</span>
                    </p>
                    <p><input type="text" name="prenom" value="'.$prenom.'">
                    </p>
                </div>

                <div>
                    <p>
                        <label for="editeur">Editeur <span class="need">*</span></label>
                        <select name="editeur">
                            ';
                            liste_option_editeur($editeur);
                            echo '
                        </select>
                        <span class="needmessage">'.$editeurerr.'</span>
                    </p>
                </div>

                <div>
                    <p>
                        <label for="naissance">Date de naissance</label>
                    </p>
                    <p>
                        <input type="Date" name="naissance" value="'.$naissance.'">
                    </p>
                </div>

                <div>
                    <p>
                        <label for="bio">Biographie <span class="need">*</span></label>
                        <span class="needmessage">'.$bioerr.'</span>
                    </p>
                    <p>
                        <textarea class="textarea" name="bio" rows="5" cols="100">'.$bio.'</textarea>
                    </p>
                </div>

                <div>
                    <p>
                        <label for="image_auteur">Photo de profil de l\'auteur </label>
                    </p>
                    <p>
                        <input type="file" name="image_auteur" accept="image/png, image/jpeg, image/jpg">
                    </p>
                </div>

                <div class="need_submit">
                    <p>Les élément suivis d\'une * sont obligatoire !</p>
                    <input name="envoyer" type="submit" value="Envoyer">
                </div>

            </form>

        </main>';


    footer("./controleur.php?action=newauteur");

}


?>


<?php
/* ************ */
/* Modif auteur */
/* ************ */



function modif_auteur($auteur){

    $result = sql_auteur($auteur);

    $nom = $result['nom_au'];
    $prenom = $result['prenom_au'];
    $bio = $result['bio_au'];
    $naissance = $result['naissance_au'];
    $editeur = $result['id_ed'];
    
    $nomerr = $prenomerr = $bioerr = $editeurerr = "";


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $nom = verifInput($_POST['nom']);
        $prenom = verifInput($_POST['prenom']);
        $bio = verifInput($_POST['bio']);
        $naissance = verifInput($_POST['naissance']);
        
        if(!empty($nom) && !empty($prenom) && !empty($bio)){
            $pdo = connexion();

            $query = $pdo->prepare('UPDATE `auteurs` SET `nom_au` = \''.$nom.'\', `prenom_au` = \''.$prenom.'\', `bio_au` = \''.$bio.'\', `naissance_au` = \''.$naissance.'\', `ed_id` = \''.$editeur.'\' WHERE `auteur`.`id_au` = '.$auteur.'');
            $query->execute();
                        
            header('Location: ./controleur.php?action=auteur&id='.$auteur.'');
    
            die();

        }else{
            if(empty($nom)){
                $nomerr = "Le nom de l'auteur est necessaire!";
            }
            if(empty($prenom)){
                $prenomerr = "Le prenom de l'auteur est necessaire!";
            }
            if(empty($bio)){
                $bioerr = "La biographie de l'auteur est necessaire!";
            }
        }

    }
    Doctype_header_nav();

echo '
        <main class="main_formulaire">

            <form method="POST" class="formulaire" enctype="multipart/form-data">

                <div>
                    <p>
                        <label for="nom">Nom <span class="need">*</span></label>
                        <span class="needmessage">'.$nomerr.'</span>
                    </p>
                    <p>
                        <input type="text" name="nom" value="'.$nom.'">
                    </p>
                </div>

                <div>
                    <p>
                        <label for="prenom">Prenom <span class="need">*</span></label>
                        <span class="needmessage">'.$prenomerr.'</span>
                    </p>
                    <p><input type="text" name="prenom" value="'.$prenom.'">
                    </p>
                </div>

                <div>
                    <p>
                        <label for="editeur">Editeur <span class="need">*</span></label>
                        <select name="editeur">
                            ';
                            liste_option_editeur($editeur);
                            echo '
                        </select>
                        <span class="needmessage">'.$editeurerr.'</span>
                    </p>
                </div>

                <div>
                    <p>
                        <label for="naissance">Date de naissance</label>
                    </p>
                    <p>
                        <input type="Date" name="naissance" value="'.$naissance.'">
                    </p>
                </div>

                <div>
                    <p>
                        <label for="bio">Biographie <span class="need">*</span></label>
                        <span class="needmessage">'.$bioerr.'</span>
                    </p>
                    <p>
                        <textarea class="textarea" name="bio" rows="5" cols="100">'.$bio.'</textarea>
                    </p>
                </div>

                <div class="need_submit">
                    <p>Les élément suivis d\'une * sont obligatoire !</p>
                    <input name="envoyer" type="submit" value="Envoyer">
                </div>

            </form>

        </main>';


    footer("./controleur.php?action=updateauteur");

}


?>

<?php
/* ************ */
/* suppr auteur */
/* ************ */

function suppr_auteur($id){

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        if($_POST['suppr'] == 'Envoyer'){

            $pdo = connexion();
            $query = $pdo->prepare('DELETE FROM `auteurs` WHERE `auteurs`.`id_au` = '.$id.'');
            $query->execute();
            
            header('Location: ./controleur.php?action=auteurs');

            die();
        }elseif($_POST['garder'] == 'garder'){
            header('Location: ./controleur.php?action=auteur&id='.$id.'');
        }


    }

    Doctype_header_nav();

    echo '<main  class="main_formulaire">

            <form method="POST" class="formulaire form_suppr">

                <p class="p_suppr">Etes-vous sur de vouloir supprimer cette auteur et tout ces livres?</p>
                <button value="garder" name="garder"  class="btn_garder">Non garder</button>
                <button type="submit" value="Envoyer" name="suppr"  class="btn_suppr">Oui supprimer</button>

            </form>

        </main>';

    footer("./controleur.php?action=supprauteur");
}

?>



<?php
/* ************* */
/* Ajout editeur */
/* ************* */



function ajout_editeur(){

    $nom = $adresse = "";   
    $nomerr = "";


    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
    $nom = verifInput($_POST['nom']);
    $adresse = verifInput($_POST['adresse']);

        
        if(!empty($nom)){

            $emplacement = './image/editeurs/'; // dossier où sera déplacé le fichier

            $tmp_file = $_FILES['image_editeur']['tmp_name'];

            $image = './image/img_par_defaut.jpg';

            if( is_uploaded_file($tmp_file) ){

                // on vérifie maintenant l'extension
                $type_file = $_FILES['image_editeur']['type'];

                if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'png')){
                    exit("Le fichier n'est pas une image");
                }else{

                    // on copie le fichier dans le dossier de destination
                    $name_file = $_FILES['image_editeur']['name'];
                    
                    
                    if( !move_uploaded_file($tmp_file, $emplacement . $name_file) ){
                    }else{
                        $newname = preg_replace( "# #", "_", $_POST['nom']).".jpg";
                        $name = rename( $emplacement.$name_file,  $emplacement.$newname);
                        $image = './image/editeurs/'.$newname;

                        $pdo = connexion();

                        $query = $pdo->prepare('INSERT INTO editeurs (nom_ed, adresse_ed, img_ed) VALUES (?, ?, ?)');
                        $query->execute([$nom, $adresse, $image]);

                        $newid = $pdo->lastInsertId();
                        
                        header('Location: ./controleur.php?action=editeur&id='.$newid.'');

                        die();

                    }
                }
            }else{

                $pdo = connexion();

                $query = $pdo->prepare('INSERT INTO editeurs (nom_ed, adresse_ed, img_ed) VALUES (?, ?, ?)');
                $query->execute([$_POST['nom'], $_POST['adresse'], $image]);

                $newid = $pdo->lastInsertId();
                
                header('Location: ./controleur.php?action=editeur&id='.$newid.'');

                die();
            }

        }else{
            $nomerr = "Le nom de l'editeur est necessaire!";
        }

    }

    Doctype_header_nav();

    echo '
    <main class="main_formulaire">

        <form method="POST" enctype="multipart/form-data" class="formulaire">

            <div>
                <p>
                    <label for="nom">Nom <span class="need">*</span></label>
                    <span class="needmessage">'.$nomerr.'</span>
                </p>
                <p>
                    <input type="text" name="nom" value="'.$nom.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="adresse">Adresse</label>
                </p>
                <p>
                    <input type="text" name="adresse" value="'.$adresse.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="image_editeur">Logo de l\'editeur</label>
                </p>
                <p>
                    <input type="file" name="image_editeur" accept="image/png, image/jpeg, image/jpg">
                </p>
            </div>

            <div class="need_submit">
                <p>Les élément suivis d\'une * sont obligatoire !</p>
                <input name="envoyer" type="submit" value="Envoyer">
            </div>

        </form>

    </main>';

    footer("./controleur.php?action=newediteur");

}

?>


<?php


/* ************* */
/* Modif editeur */
/* ************* */



function modif_editeur($editeur){

    $result = sql_editeur($editeur);


    $nom = $result['nom_ed'];
    $adresse = $result['adresse_ed'];

    $nomerr = "";


    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        $nom = verifInput($_POST['nom']);
        $adresse = verifInput($_POST['adresse']);

        
        if(!empty($nom)){

            $pdo = connexion();
            $query = $pdo->prepare('UPDATE `editeurs` SET `nom_ed` = \''.$nom.'\', `adresse_ed` = \''.$adresse.'\' WHERE `editeurs`.`id_ed` = '.$editeur.'');
            $query->execute();
            
            header('Location: ./controleur.php?action=editeur&id='.$editeur.'');

            die();

        }else{
            $nomerr = "Le nom de l'editeur est necessaire!";
        }

    }

    Doctype_header_nav();

    echo '
    <main class="main_formulaire">

        <form method="POST" enctype="multipart/form-data" class="formulaire">

            <div>
                <p>
                    <label for="nom">Nom <span class="need">*</span></label>
                    <span class="needmessage">'.$nomerr.'</span>
                </p>
                <p>
                    <input type="text" name="nom" value="'.$nom.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="adresse">Adresse</label>
                </p>
                <p>
                    <input type="text" name="adresse" value="'.$adresse.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="image_editeur">Logo de l\'editeur</label>
                </p>
                <p>
                    <input type="file" name="image_editeur" accept="image/png, image/jpeg, image/jpg">
                </p>
            </div>

            <div class="need_submit">
                <p>Les élément suivis d\'une * sont obligatoire !</p>
                <input name="envoyer" type="submit" value="Envoyer">
            </div>

        </form>

    </main>';

    footer("./controleur.php?action=updateediteur");

}

?>

<?php
/* ************* */
/* suppr editeur */
/* ************* */

function suppr_editeur($id){

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        if($_POST['suppr'] == 'Envoyer'){

            $pdo = connexion();
            $query = $pdo->prepare('DELETE FROM `editeurs` WHERE `editeurs`.`id_ed` = '.$id.'');
            $query->execute();
            
            header('Location: ./controleur.php?action=editeurs');

            die();
        }elseif($_POST['garder'] == 'garder'){
            header('Location: ./controleur.php?action=editeur&id='.$id.'');
        }


    }

    Doctype_header_nav();

    echo '<main  class="main_formulaire">

            <form method="POST" class="formulaire form_suppr">

                <p class="p_suppr">Etes-vous sur de vouloir supprimer cette editeur et tout ce qui le concerne (Auteurs et livres) ?</p>
                <button value="garder" name="garder"  class="btn_garder">Non garder</button>
                <button type="submit" value="Envoyer" name="suppr"  class="btn_suppr">Oui supprimer</button>

            </form>

        </main>';

    footer("./controleur.php?action=supprediteur");
}

?>


<?php
/* *********** */
/* Ajout livre */
/* *********** */



function ajout_livre(){

        
    $isbnerr = $auteurerr = $titreerr = $image_livreerr = "";
    $isbn = $auteur = $titre = $prix = $resume = "";


    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        $isbn = verifInput($_POST['isbn']);
        $auteur = verifInput($_POST['auteur']);
        $titre = verifInput($_POST['titre']);
        $prix = verifInput($_POST['prix']);
        $resume = verifInput($_POST['resume']);
            
        if(!empty($isbn) && !empty($auteur) && !empty($titre) && !empty($_FILES['image_livre'])){

            $emplacement = './image/livres/'; // dossier où sera déplacé le fichier


            $tmp_file = $_FILES['image_livre']['tmp_name'];
        
            $image = './image/img_par_defaut.jpg';
        
            if( is_uploaded_file($tmp_file) ){
        
                // on vérifie maintenant l'extension
                $type_file = $_FILES['image_livre']['type'];
        
                if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') &&!strstr($type_file, 'png')){
                    exit("Le fichier n'est pas une image");
                }else{
        
                    // on copie le fichier dans le dossier de destination
                    $name_file = $_FILES['image_livre']['name'];
                        
                        
                    if( !move_uploaded_file($tmp_file, $emplacement . $name_file) ){
                    }else{
                        $newname = preg_replace( "# #", "_", $_POST['titre']).".jpg";
                        $name = rename( $emplacement.$name_file,  $emplacement.$newname);
                        $image = './image/livres/'.$newname;

                        $pdo = connexion();

                        $query = $pdo->prepare('INSERT INTO livres (isbn, titre_livre, prix_livre, img_livre, resume_livre, id_au) VALUES (?, ?, ?, ?, ?, ?)');
                        $query->execute([$isbn, $titre, $prix, $image, $resume, $auteur]);
        
                        $newid = $pdo->lastInsertId();
                            
                        header('Location: ./controleur.php?action=livre&id='.$newid.'');
        
                        die();
        
                    }
                }
            }
        
        }else{
            if(empty($titre)){
                $titreerr = "Le titre du livre est necessaire!";
            }
            if(empty($isbn)){
                $isbnerr = "L'ISBN est necessaire!";
            }
            if(empty($auteur)){
                $auteurerr = "L'auteur est necessaire!";
            }
            if(empty($_FILES['image_livre'])){
                $image_livreerr = "La couverture du livre est necessaire!";
            }
        }

    }

    Doctype_header_nav();

    echo '
    <main class="main_formulaire">

        <form method="POST" class="formulaire" enctype="multipart/form-data">

            <div>
                <p>
                    <label for="isbn">ISBN <span class="need">*</span></label>
                    <span class="needmessage">'.$isbnerr.'</span>
                </p>
                <p>
                    <input type="number" name="isbn" value="'.$isbn.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="auteur">Auteur <span class="need">*</span></label>
                    <select name="auteur">';
                        liste_option_auteur($auteur);
                    echo'
                    </select>
                    <span class="needmessage">'.$auteurerr.'</span>
                </p>
            </div>

            <div>
                <p>
                    <label for="titre">Titre <span class="need">*</span></label>
                    <span class="needmessage">'.$titreerr.'</span>
                </p>
                <p><input type="text" name="titre" value="'.$titre.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="prix">Prix</label>
                </p>
                <p>
                    <input type="number" step="0.01" name="prix" value="'.$prix.'">
                    <label for="prix">€</label>
                </p>
            </div>

            <div>
                <p>
                    <label for="resume">Résumé </label>
                </p>
                <p>
                    <textarea class="textarea" name="resume" rows="5" cols="100" autocomplete="on">'.$resume.'</textarea>
                </p>
            </div>

            <div>
                <p>
                    <label for="image_livre">La couverture du livre <span class="need">*</span></label>
                    <span class="needmessage">'.$image_livreerr.'</span>
                </p>
                <p>
                    <input type="file" name="image_livre" accept="image/png, image/jpeg, image/jpg">
                </p>
            </div>

            <div class="need_submit">
                <p>Les élément suivis d\'une * sont obligatoire !</p>
                <input name="envoyer" type="submit" value="Envoyer">
            </div>

        </form>

    </main>';

    footer("./controleur.php?action=newlivre");

}

?>



<?php
/* *********** */
/* Modif livre */
/* *********** */



function modif_livre($livre){

    $result = sql_livre($livre);

    $isbn = $result['isbn'];
    $titre = $result['titre_livre'];
    $prix = $result['prix_livre'];
    $resume = $result['resume_livre'];
    $auteur = $result['id_au'];
        
    $isbnerr = $auteurerr = $titreerr = "";


    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        $isbn = verifInput($_POST['isbn']);
        $auteur = verifInput($_POST['id_au']);
        $titre = verifInput($_POST['titre']);
        $prix = verifInput($_POST['prix']);
        $resume = verifInput($_POST['resume']);
            
        if(!empty($isbn) && !empty($auteur) && !empty($titre)){

            $pdo = connexion();
            $query = $pdo->prepare('UPDATE `livres` SET `isbn` = \''.$isbn.'\', `titre_livre` = \''.$titre.'\', `prix_livre` = \''.$prix.'\', `resume_livre` = \''.$resume.'\', `id_au` = \''.$auteur.'\' WHERE `livres`.`id_livre` = '.$livre.'');
            $query->execute();
            
            header('Location: ./controleur.php?action=livre&id='.$livre.'');

            die();

        }else{
            if(empty($titre)){
                $titreerr = "Le titre du livre est necessaire!";
            }
            if(empty($isbn)){
                $isbnerr = "L'ISBN est necessaire!";
            }
            if(empty($auteur)){
                $auteurerr = "L'auteur est necessaire!";
            }
            if(empty($_FILES['image_livre'])){
                $image_livreerr = "La couverture du livre est necessaire!";
            }
        }

    }

    Doctype_header_nav();

    echo '
    <main class="main_formulaire">

        <form method="POST" class="formulaire" enctype="multipart/form-data">

            <div>
                <p>
                    <label for="isbn">ISBN <span class="need">*</span></label>
                    <span class="needmessage">'.$isbnerr.'</span>
                </p>
                <p>
                    <input type="number" name="isbn" value="'.$isbn.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="auteur">Auteur <span class="need">*</span></label>
                    <select name="auteur">';
                        liste_option_auteur($auteur);
                    echo'
                    </select>
                    <span class="needmessage">'.$auteurerr.'</span>
                </p>
            </div>

            <div>
                <p>
                    <label for="titre">Titre <span class="need">*</span></label>
                    <span class="needmessage">'.$titreerr.'</span>
                </p>
                <p><input type="text" name="titre" value="'.$titre.'">
                </p>
            </div>

            <div>
                <p>
                    <label for="prix">Prix</label>
                </p>
                <p>
                    <input type="number" step="0.01" name="prix" value="'.$prix.'">
                    <label for="prix">€</label>
                </p>
            </div>

            <div>
                <p>
                    <label for="resume">Résumé </label>
                </p>
                <p>
                    <textarea class="textarea" name="resume" rows="5" cols="100" autocomplete="on">'.$resume.'</textarea>
                </p>
            </div>

            <div class="need_submit">
                <p>Les élément suivis d\'une * sont obligatoire !</p>
                <input name="envoyer" type="submit" value="Envoyer">
            </div>

        </form>

    </main>';

    footer("./controleur.php?action=updatelivre");

}

?>

<?php
/* *********** */
/* suppr livre */
/* *********** */

function suppr_livre($id){

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        if($_POST['suppr'] == 'Envoyer'){

            $pdo = connexion();
            $query = $pdo->prepare('DELETE FROM `livres` WHERE `livres`.`id_livre` = '.$id.'');
            $query->execute();
            
            header('Location: ./controleur.php?action=livres');

            die();
        }elseif($_POST['garder'] == 'garder'){
            header('Location: ./controleur.php?action=livre&id='.$id.'');
            die();
        }


    }

    Doctype_header_nav();

    echo '<main  class="main_formulaire">

            <form method="POST" class="formulaire form_suppr">

                <p class="p_suppr">Etes-vous sur de vouloir le supprimer ?</p>
                <button value="garder" name="garder"  class="btn_garder">Non garder</button>
                <button type="submit" value="Envoyer" name="suppr"  class="btn_suppr">Oui supprimer</button>

            </form>

        </main>';

    footer("./controleur.php?action=supprlivre");
}

?>