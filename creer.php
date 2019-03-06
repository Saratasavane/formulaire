<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=busness_money', 'root','');

if(isset($_POST['forminscription']))
{
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
    
    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {
       
        
        $pseudolength = strlen($pseudo);
        if($pseudolength <= 255)
        {
             if($mail == $mail2) 
             {
                 if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                {
                    $reqmail = $bdd->prepare("SELECT * FROM money WHERE mail = ?");
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    if($mailexist == 0)
                    {
                         
                     
                     
                if($mdp == $mdp2)
                {
                    $insertmbr = $bdd->prepare("INSERT INTO money(pseudo, mail, motdepasse) VALUES(?,?,?)");
                    $insertmbr->execute(array($pseudo, $mail, mdp));
                    $erreur = "Votre compte a bien ete cree! <a href=\"connexion.php\">Me connecter</a>";
                }
                 else
                 {
                     $erreur = "Vos mots de passe ne correspondent pas!";
                 }
                  }
                    else
                    {
                        $erreur = "Adresse mail deja utilisee!";
                    }
                     
                }
                 else
                 {
                     $erreur = "Votre adresses mail n'est pas valide!"; 
                 }
             }
            else
            {
                $erreur = "vos adresses mail ne correspondent pas!";
            }
        }
        else
        {
            $erreur = "Votre pseudo ne doit pas depasser 255 caracteres!";
        }
    }
    else
    {
       $erreur = "Tous les champs doivent etre remplis!";
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Formulaire</title>
        <meta charset="utf-8">
         
    </head>
    <body>
        <div align="center">
            <h2>INSCRIVEZ-VOUS</h2>
            <br /><br />
            <form method="POST" action="">
                <table>
                    <tr>
                    <td align="right">
                        <label for="pseudo">Pseudo:</label>
                        </td>
                        <td>
                        <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" class="form-control" value="<?php if(isset($pseudo)) { echo $pseudo;}?>"/>
                        </td>
                        </tr>
                    <tr>
                        <td align="right">
                        <label for="mail">mail:</label>
                        </td>
                        <td>
                        <input type="mail" placeholder="Votre mail" id="mail" name="mail" class="form-control"  value="<?php if(isset($mail)) { echo $mail;}?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                        <label for="mail2">Confirmation du mail:</label>
                        </td>
                        <td>
                        <input type="mail" placeholder="Confirmez votre mail" id="mail2" name="mail2" class="form-control" value="<?php if(isset($mail2)) { echo $mail2;}?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                        <label for="mdp">Mot de passe:</label>
                        </td>
                        <td>
                        <input type="password" placeholder="Votre mot de passe" class="form-control" id="mdp" name="mdp"/>
                        </td>
                        </tr>
                        <tr>
                        <td align="right">
                        <label for="mdp2">Confirmation du mot de passe:</label>
                        </td>
                        <td>
                        <input type="password" placeholder="Confirmez votre mot de passe" class="form-control" id="mdp2" name="mdp2"/>
                        </td>
                        </tr>
                        <tr>
                            <td></td>
                    <td align="right">
                        <br />
                        <input type="submit" name="forminscription" class="form-control" value="je m'inscris"/>
                    </td>
                    </tr>
                </table>
                 
            </form>
            <?php
            if(isset($erreur))
            {
                echo '<font-color="red">' .$erreur."</font>";
            }
            ?>
        
        </div>
    
    </body>

</html>
