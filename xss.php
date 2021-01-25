<?php
if (!isset($_POST['faille'])){ ?>
     <div class="question formulaire">
         <p>Les failles XSS</p>
            <form action="xss.php" method="post">
                <input type="text" name="faille">
                <input type="submit" value="Envoyer">
            </form>
     </div>
<?php }
else {
    echo "Ma faille : " + $_POST['faille'];
}
