<?php

function Doctype_header_nav($en_cours = ""){
    

    echo '<!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://kit.fontawesome.com/bf96a16ec0.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="./style/style.css">
            <link rel="icon" href="./image/logo.ico" />
            <title>Empreinte d\'un lecteur</title>
        </head>

        <body>';

    if($en_cours !== "./controleur.php" ){
        echo '<header>
            <div class="header">
                <div class="logo_nom">
                    <a class="nom_logo" href="controleur.php"><div><img class="logo" src="./image/logo.svg"></div>
                    <div class="nom"><img src="./image/nom.svg"></div></a>
                </div>
                <div class="search">
                    <form action="./controleur.php?action=search" method="POST" class="page">
                        <input id="S" type="search" name="q" placeholder="Votre Recherche" autocomplete="off" />
                        <label for="OK"><i class="fas fa-search"></i></label>
                        <input id="OK" type="submit" value="OK" name="submit" />
                    </form>
                </div>
            </div>
        </header>';
    }else{
        echo '<header>
            <div class="header">
            <div class="logo_nom">
            <a class="nom_logo" href="controleur.php"><div><img class="logo" src="./image/logo.svg"></div>
            <div class="nom"><img src="./image/nom.svg"></div></a>
        </div>
            </div>
            
        </header>';
    }

    echo'<nav>
            <div class="anav';
            if( $en_cours == "./controleur.php?action=livres" || $en_cours == "./controleur.php?action=livre"){echo ' active';}
            echo '"><a href="./controleur.php?action=livres">Livres</a></div>
            <div class="anav';
            if($en_cours == "./controleur.php?action=auteurs" || $en_cours == "./controleur.php?action=auteur"){echo ' active';}
            echo '"><a href="./controleur.php?action=auteurs">Auteurs</a></div>
            <div class="anav';
            if($en_cours == "./controleur.php?action=editeurs" || $en_cours == "./controleur.php?action=editeur"){echo ' active';}
            echo '"><a href="./controleur.php?action=editeurs">Editeurs</a></div>
            <div class="anav dropdown">
                <button class="dropdown_button">Ajouter</button>
                <div class="element_dropdown">
                    <a class="dropdown_nav" href="./controleur.php?action=newlivre">Un livre</a>
                    <a class="dropdown_nav" href="./controleur.php?action=newauteur">Un auteur</a>
                    <a class="dropdown_nav" href="./controleur.php?action=newediteur">Un editeur</a>
                </div>
            </div>
        </nav>';

}


function footer($en_cours = ""){

    if( $en_cours == "./controleur.php" || $en_cours == "./controleur.php?action=livre" || $en_cours == "./controleur.php?action=updateediteur" || $en_cours == "./controleur.php?action=updateauteur" || $en_cours == "./controleur.php?action=updatelivre" || $en_cours == "./controleur.php?action=newauteur" || $en_cours == "./controleur.php?action=newediteur" || $en_cours == "./controleur.php?action=newlivre" || $en_cours == "./controleur.php?action=supprlivre" || $en_cours == "./controleur.php?action=supprauteur" || $en_cours == "./controleur.php?action=supprediteur"){
        echo '<footer class="foot">
                    <p>Réaliser par REMOND Sven</p>
                </footer>
            </body>
            </html>';
    }else{
        echo '<a href="#" class="conteneur_fleche"><div><i class="fas fa-angle-double-up"></i></div>
                </a><footer>
                        <p>Réaliser par REMOND Sven</p>
                    </footer>
            </body>
            </html>';
    }
    
}

?>