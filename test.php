<?php session_start();

if (isset($_POST['detruireSession'])){ /* si la variable est définie, on détruit la session */
    unset($_SESSION);
}
if (!isset($_SESSION['reponses'])){ /* On vérifie que la session existe sinon on la crée */
    $_SESSION['reponses'] = '';
}
if (!isset($_SESSION['nbQuestion'])){
    $_SESSION['nbQuestion'] = 0;
}


$questions = array( /* Les questions */
    "Où puisez-vous votre énergie ?",
    "Comment recueillez-vous l’information ?",
    "Qu’est-ce qui entraîne vos choix et vos décisions ?",
    "De quelle manière vous lancez-vous dans l’action ?"
);

$reponses = array( /* Les reponses des 4 questions avec leurs valeurs */
    array("Dans votre propre univers intérieur", "À partir de l’environnement extérieur", "I", "E"), /* reponse[0][2] = "I" */
    array("Grâce à vos sens", "Grâce à votre intuition", "S", "N"),
    array("La logique et le raisonnement pragmatique", "Vos valeurs et votre ressenti", "T", "F"),
    array("Vous actions sont réfléchies", "Vous agissez par rapport aux circonstances", "J", "P")
);

$analyse = array(/* TOUTES les analyses de tous les profils :cry: */
    array('ISFJ', 'de protecteur ', '14,10', 'https://fr.wikipedia.org/wiki/ISFJ'),
    array('ESFJ', 'de bon vivant', '12,50', 'https://fr.wikipedia.org/wiki/ESFJ'),
    array('ISTJ', 'd\'administrateur', '11,60', 'https://fr.wikipedia.org/wiki/ISTJ'),
    array('ISFP', 'd\'artiste ', '8,80', 'https://fr.wikipedia.org/wiki/ISFP'),
    array('ESTJ', 'de manager ', '8,70', 'https://fr.wikipedia.org/wiki/ESTJ'),
    array('ESFP', 'd\'acteur', '8,50', 'https://fr.wikipedia.org/wiki/ESFP'),
    array('ENFP', 'de psychologue ', '8,10', 'https://fr.wikipedia.org/wiki/ENFP'),
    array('ISTP', 'd\'artisan ', '5,40', 'https://fr.wikipedia.org/wiki/ISTP_(type_de_personnalit%C3%A9)'),
    array('ESTP', 'de promoteur ', '4,30', 'https://fr.wikipedia.org/wiki/ESTP'),
    array('INFP', 'd\'idéaliste  ', '3,60', 'https://fr.wikipedia.org/wiki/INFP'),
    array('INTP', 'de chercheur ', '3,30', 'https://fr.wikipedia.org/wiki/INTP'),
    array('ENTP', 'd\'inventeur', '3,20', 'https://fr.wikipedia.org/wiki/ENTP'),
    array('ENFJ', 'd\'animateur', '2,50', 'https://fr.wikipedia.org/wiki/ENFJ'),
    array('INTJ', 'd\'organisateur', '2,10', 'https://fr.wikipedia.org/wiki/INTJ'),
    array('ENTJ', 'l\'entrepreneur', '1,80', 'https://fr.wikipedia.org/wiki/ENTJ'),
    array('INFJ', 'de conseiller', '1,50', 'https://fr.wikipedia.org/wiki/INFG'));

/* Debug */

print_r("Session : ");
print_r($_SESSION);
print_r("Post :");
print_r($_POST);

/* Fin du debug */


/* Création des variables qui seront en paramètre des forms */

$cas = 2; /* Par default en erreur */
$nbQuestion = 0;
$question = "";
$rep1 = "";
$rep2 = "";
$valeurRep1 = "";
$valeurRep2 = "";
$nom = "";
$profil = "";
$pourcentage = 0;
$lien = "";

/* Fin de la création des variables */

if (!isset($_POST['nbQuestion'])){ /* Première question */
    if ($_SESSION['nbQuestion'] == 0){
        $cas = 0; /* On affiche les questions */
        $question = $questions[0];
        $rep1 = $reponses[0][0];
        $valeurRep1 = $reponses[0][2];
        $rep2 = $reponses[0][1];
        $valeurRep2 = $reponses[0][3];
        $nbQuestion = 1;
        $_SESSION['nbQuestion'] = 1;
    }
} elseif (intval($_POST['nbQuestion']) < 4){
    if ($_SESSION['nbQuestion'] == $_POST['nbQuestion']){
        $cas = 0; /* On affiche les questions */
        $_SESSION['reponses'] = $_SESSION['reponses'] . "" . $_POST['reponse'];
        $index = intval($_POST['nbQuestion']);
        $question = $questions[$index];
        $rep1 = $reponses[$index][0];
        $valeurRep1 = $reponses[$index][2];
        $rep2 = $reponses[$index][1];
        $valeurRep2 = $reponses[$index][3];
        $nbQuestion = intval($_POST['nbQuestion']) + 1;
        $_SESSION['nbQuestion'] = intval($_SESSION['nbQuestion']) + 1;
    }
}else {
    if ($_SESSION['nbQuestion'] == $_POST['nbQuestion']){
        $cas = 1; /* On affiche le résultat */
        $_SESSION['reponses'] = $_SESSION['reponses'] . "" . $_POST['reponse'];
        $profil = $_SESSION['reponses'];
        unset($_SESSION); /* On détruit les variables de session */
        session_destroy(); /* On ferme la session */

        $index = -1;

        for ($i = 0; $i < count($analyse); $i++){ /* On parcourt le tableau pour trouver l'index du profil */
            if ($profil == $analyse[$i][0]){
                $index = $i;
            }
        }

        if ($index == -1){ /* S'il y a une erreur */
            /* $nom, $profil, $pourcentage, $lien */
            $nom = "ERREUR";
            $pourcentage = 0;
            $lien = "https://google.ru";

        }else { /* Sinon */
            $nom = $analyse[$index][1];
            $pourcentage = $analyse[$index][2];
            $lien = $analyse[$index][3];
        }

    }
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>LE TEST | Qui êtes vous ?</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
        <link rel='stylesheet' type='text/css' media='screen' href='test.css'>
        <link rel="icon" type="image/ico" href="img/favicon.ico" />
        <script src="https://kit.fontawesome.com/4beb9db8c0.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="background">
            <header>
                <nav class="nav-barre">
                    <a class="nav-barre-ele1" href="index.php"><i class="fas fa-home"></i> <em>ACCUEIL</em></a>
                    <a class="nav-barre-ele2" href="test.php"><i class="fas fa-clipboard-list"></i> <em>LE TEST</em></a>
                </nav>
            </header>
            <main class="grid-container">
                <?php
                switch ($cas){
                    case 0: /* On pose des questions */?>*

                <div class="question formulaire">
                    <p><?php echo $question; ?></p>
                    <form action="test.php" method="post">
                        <input type="hidden" name="nbQuestion" value=<?php echo $nbQuestion; ?>/>
                        <input type="hidden" name="reponse" value="<?php echo $valeurRep1; ?>">
                        <input class="myButton rouge" type="submit" value="<?php echo $rep1;?>">
                    </form>
                    <form action="test.php" method="post">
                        <input type="hidden" name="nbQuestion" value=<?php echo $nbQuestion; ?>/>
                        <input type="hidden" name="reponse" value="<?php echo  $valeurRep2; ?>">
                        <input class="myButton vert" type="submit" value="<?php echo $rep2; ?>">
                    </form>
                </div>

                <?php
                        break;
                    case 1: /* On affiche les résultats */?>

                <div class="resultat">
                    <p>Vous avez un profil "<?php echo $nom; ?>" ("<?php echo $profil; ?>"), comme <?php echo $pourcentage; ?>% de la population</p>
                    <br>
                    <a target=\"_blank\" href="<?php echo $lien; ?>" class='myButton vert'>En savoir plus</a>";
                </div>

                <?php
                        break;
                    case 2: /* On a une erreur */ ?>

                <div class="erreur question formulaire">
                    <p>Vous avez rafraîchi la page pendant le quiz.</p>
                    <form action="test.php" method="post">
                        <input type="hidden" name="detruireSession" value="true"/>
                        <input class="myButton vert" type="submit" value="Recommencer">
                    </form>
                </div>
                <?php
                }
                ?>
            </main>
        </div>
    </body>
</html>