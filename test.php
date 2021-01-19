<?php session_start();

if (isset($_POST['detruireSession'])){ /* si la variable est définie, on détruit la session */
    session_unset();
    unset($_POST['detruireSession']);
}
if (!isset($_SESSION['reponses'])){ /* On vérifie que la session existe sinon on la crée */
    $_SESSION['reponses'] = '';
}elseif (strlen($_SESSION['reponses']) > 3){
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
    /* Description pas faite */array('ISFJ', 'de protecteur ', '14,10', 'https://fr.wikipedia.org/wiki/ISFJ', 'Le type de personnalité des protecteurs est tout à fait unique, car beaucoup de leurs qualités défient toute définition de leurs traits individuels. Bien que compréhensifs, les protecteurs peuvent être farouches lorsqu’ils doivent protéger leur famille ou leurs amis. Bien que calmes et réservés, ils ont un sens solide du contact humain et des relations humaines approfondies. Bien qu’ils recherchent la stabilité et la sécurité, ils sont souvent réceptifs au changement et aux nouvelles idées. Comme tant de choses, les gens qui ont le type de personnalité « protecteur » sont plus que la somme de leurs parties et c’est la manière dont ils utilisent ces points forts qui définit qui ils sont.'),
    /* Description pas faite */array('ESFJ', 'de bon vivant', '12,50', 'https://fr.wikipedia.org/wiki/ESFJ', 'Les gens qui partagent le type de personnalité « bon vivant» sont, faute d’un meilleur terme, populaires, ce qui est logique, vu que c’est aussi un type de personnalité très répandu qui représente douze pourcent de la population. Au lycée, les bon vivants sont les majorettes et les quarterbacks, ceux qui donnent le ton, captent la lumière des projecteurs et mènent leur équipe vers la victoire et la célébrité. Plus tard dans leur vie, les bon vivants aiment encore soutenir leurs amis et ceux qu’ils aiment, organiser des rencontres sociales et faire de leur mieux pour s’assurer que tout le monde est heureux.'),
    /* Description pas faite */array('ISTJ', 'd\'administrateur', '11,60', 'https://fr.wikipedia.org/wiki/ISTJ', ''),
    /* Description pas faite */array('ISFP', 'd\'artiste ', '8,80', 'https://fr.wikipedia.org/wiki/ISFP', ''),
    /* Description pas faite */array('ESTJ', 'de manager ', '8,70', 'https://fr.wikipedia.org/wiki/ESTJ', ''),
    /* Description pas faite */array('ESFP', 'd\'acteur', '8,50', 'https://fr.wikipedia.org/wiki/ESFP', ''),
    /* Description pas faite */array('ENFP', 'de psychologue ', '8,10', 'https://fr.wikipedia.org/wiki/ENFP', ''),
    /* Description pas faite */array('ISTP', 'd\'artisan ', '5,40', 'https://fr.wikipedia.org/wiki/ISTP_(type_de_personnalit%C3%A9)', ''),
    /* Description pas faite */array('ESTP', 'de promoteur ', '4,30', 'https://fr.wikipedia.org/wiki/ESTP', ''),
    /* Description pas faite */array('INFP', 'd\'idéaliste  ', '3,60', 'https://fr.wikipedia.org/wiki/INFP', ''),
    array('INTP', 'de chercheur ', '3,30', 'https://fr.wikipedia.org/wiki/INTP', 'Vous aimez aider les autres mais n’aimez pas être sous les projecteurs, vous êtes pudique, curieux, sans cesse entrain d’explorer de nouveaux sujets ! Vous êtes franc avec vos proches, et même si vous vous mettez en retrait en groupe, vous observez beaucoup ce qui vous entoure. Le profil INTP doit absolument se nourrir du monde extérieur pour lui permettre d’avoir de nouveaux projets et de nourrir son besoin de réflexion.'),
    array('ENTP', 'd\'inventeur', '3,20', 'https://fr.wikipedia.org/wiki/ENTP', 'Vous vous intéressez à des sujets très variés, il est donc difficile de vous mettre dans une case, vous aimez vous engager dans plusieurs causes/sujets/objectifs à la fois mais vous ne finissez pas toujours vos projets. Vous avez tendance à vous éparpiller et à être facilement distrait. A la fois rationnel et fantaisiste, vous avez de l’imagination analytique, ce qui aboutit à des idées originales mais il est difficile de le mettre en œuvre. Vous aimez débattre pour la richesse des argumentes et vous vous rangez souvent du côté de l’avocat du diable pour enrichir votre esprit innovateur. Vous allez donner des conseils aux autres meme si on ne vous a rien demandé. Vous détestez le searches répétitives, désordonné, le profil ENTP a besoin d’ancrage dans le monde physique, il a besoin pour cela de rester dans l’action et se discipliner.'),
    /* Description pas faite */array('ENFJ', 'd\'animateur', '2,50', 'https://fr.wikipedia.org/wiki/ENFJ', ''),
    array('INTJ', 'd\'organisateur', '2,10', 'https://fr.wikipedia.org/wiki/INTJ', 'Vous êtes stratégique, penseur et efficace, il faut aller à l’essentiel ! Vous, êtes plutôt introverti et  agissez de manière inconsciente, grâce à une idée de génie ! Votre grande capacité de mémorisation est un atout, vous voulez améliorer, perfectionner, trouver des solutions, inutile de perdre son temps pour des futilités. Vous êtes souvent persuadés que vous avez raison, mais attention à ne pas passer à côté d’autres idées. Vous n’allez pas forcément vers les autres, mais vous pouvez être naïf et sensible, il faut trouver un juste équilibre afin de ne pas perdre pied. L’INTJ ne se laisse pas approché facilement mais une fois cette étape franchie, vous aurez une place importante à ses yeux. '),
    array('ENTJ', 'l\'entrepreneur', '1,80', 'https://fr.wikipedia.org/wiki/ENTJ', 'Vous savez vous montrez très persuasif, autoritaire, vous aimez diriger, vous pensez pour agir ! Charismatique, vous aimez vous surpasser et vous êtes un grand bosseur ! Votre impatience peut vous empêcher d’avoir des idées innovantes et votre intuition introvertie peut être mise à rude épreuve. Il est important de prendre soin de vous, vous devez accorder davantage d’importance à vos valeurs et vos sentiments, il ne faut pas les négliger !'),
    /* Description pas faite */array('INFJ', 'de conseiller', '1,50', 'https://fr.wikipedia.org/wiki/INFG', ''));

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
        session_unset(); /* On détruit les variables de session */
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
                    <p class="titre">Vous avez un profil "<?php echo $nom; ?>" (<?php echo $profil; ?>), comme <?php echo $pourcentage; ?>% de la population</p>
                    <br>
                    <br>
                    <a target=\"_blank\" href="<?php echo $lien; ?>" class='myButton vert'>En savoir plus</a>
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