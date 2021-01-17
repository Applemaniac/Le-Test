<?php session_start();


if (!isset($_SESSION['reponses'])){ /* On vérifie que la session existe sinon on la crée */
    $_SESSION['reponses'] = '';
}
if (isset($_POST['detruireSession'])){ /* si la variable est définie, on détruit la session */
    unset($_SESSION['reponses']);
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
    array('ISFJ', '14,10', 'https://fr.wikipedia.org/wiki/ISFJ'),
    array('ESFJ', '12,50', 'https://fr.wikipedia.org/wiki/ESFJ'),
    array('ISTJ', '11,60', 'https://fr.wikipedia.org/wiki/ISTJ'),
    array('ISFP', '8,80', 'https://fr.wikipedia.org/wiki/ISFP'),
    array('ESTJ', '8,70', 'https://fr.wikipedia.org/wiki/ESTJ'),
    array('ESFP', '8,50', 'https://fr.wikipedia.org/wiki/ESFP'),
    array('ENFP', '8,10', 'https://fr.wikipedia.org/wiki/ENFP'),
    array('ISTP', '5,40', 'https://fr.wikipedia.org/wiki/ISTP_(type_de_personnalit%C3%A9)'),
    array('ESTP', '4,30', 'https://fr.wikipedia.org/wiki/ESTP'),
    array('INFP', '3,60', 'https://fr.wikipedia.org/wiki/INFP'),
    array('INTP', '3,30', 'https://fr.wikipedia.org/wiki/INTP'),
    array('ENTP', '3,20', 'https://fr.wikipedia.org/wiki/ENTP'),
    array('ENFJ', '2,50', 'https://fr.wikipedia.org/wiki/ENFJ'),
    array('INTJ', '2,10', 'https://fr.wikipedia.org/wiki/INTJ'),
    array('ENTJ', '1,80', 'https://fr.wikipedia.org/wiki/ENTJ'),
    array('INFJ', '1,50', 'https://fr.wikipedia.org/wiki/INFG')); ?>

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
<?php if (isset($_POST['nbQuestion'])){ /* Si une question à déjà était posé */
    if($_POST['nbQuestion'] < 4 && $_POST['nbQuestion'] > 0){ /* S'il reste encore des questions */
        $_SESSION['reponses'] = $_SESSION['reponses'] . '' .$_POST['reponse'];
?>              <div class="question formulaire"> <?php
        echo '<p>' . $questions[intval($_POST['nbQuestion'])] . '</p>';
        $nbReponse = intval($_POST['nbQuestion']);
        $_POST['nbQuestion'] = intval($_POST['nbQuestion']) + 1;
?>
                <form action="test.php" method="post">
                    <input type="hidden" name="nbQuestion" value=<?php echo $_POST['nbQuestion']; ?>/>
                    <input type="hidden" name="reponse" value=<?php echo $reponses[$nbReponse][2]; ?>>
                    <input class="myButton rouge" type="submit" value="<?php echo $reponses[$nbReponse][0];?>">
                </form>
                <form action="test.php" method="post">
                    <input type="hidden" name="nbQuestion" value=<?php echo $_POST['nbQuestion']; ?>/>
                    <input type="hidden" name="reponse" value=<?php echo  $reponses[$nbReponse][3]; ?>>
                    <input class="myButton vert" type="submit" value="<?php echo $reponses[$nbReponse][1]; ?>">
                </form>
        </div>
<?php }else{ /* Si c'était la dernière question */

            $_SESSION['reponses'] = $_SESSION['reponses'] . '' .$_POST['reponse'];

            $reponse = $_SESSION['reponses'];
            $index = -1;

            for ($i = 0; $i < count($analyse); $i++){
                $var = $analyse[$i][0];
                    if($reponse == $var){
                        $index = $i;
                    }
            }

            echo '</br>';

            if ($index != -1){ /* Si tout va bien */ ?>
         <div class="resultat">
<?php
                echo '<p>Vous avez ' . $analyse[$index][0] . ' comme profil, comme ' . $analyse[$index][1] . '% de la population</p>';
                echo '</br>';
                $lien = "<a target=\"_blank\" href=". $analyse[$index][2] . " class='myButton vert'>En savoir plus</a>";
                echo $lien;
?>
         </div>
<?php
            }else{ ?>
         <div class="erreur question formulaire">
             <p>Vous avez rafraîchi la page pendant le quiz, ou vous êtes allé trop vite.</p>
             <form action="test.php" method="post">
                 <input type="hidden" name="detruireSession" value="true"/>
                 <input class="myButton vert" type="submit" value="Recommencer">
             </form>
         </div>
    <?php   }

          }
}else { /* Si on n'a pas encore posé de question */?>
            <div class="question formulaire">
<?php
    echo '<p>'.$questions[0].'</p>';
    $rep1 = $reponses[0][0];
    $rep2 = $reponses[0][1];
?>
                    <form action="test.php" method="post">
                        <input type="hidden" name="nbQuestion" value=1/>
                        <input type="hidden" name="reponse" value=<?php echo $reponses[0][2]; ?>>
                        <input class="myButton rouge" type="submit" value="<?php echo $rep1;?>">
                    </form>
                    <form action="test.php" method="post">
                        <input type="hidden" name="nbQuestion" value=1/>
                        <input type="hidden" name="reponse" value=<?php echo  $reponses[0][3]; ?>>
                        <input class="myButton vert" type="submit" value="<?php echo $rep2; ?>">
                    </form>
                </div>
<?php } ?>
            </main>
        </div>
    </body>
</html>