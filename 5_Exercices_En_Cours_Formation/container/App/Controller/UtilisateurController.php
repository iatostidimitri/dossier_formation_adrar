<?php
namespace App\Controller;
use App\Model\Utilisateur;
use App\Utils\Utilitaire;
class UtilisateurController extends Utilisateur{
    public function addUser(){
        $error = "";
        //tester si le formulaire
        if(isset($_POST['submit'])){
            //test si les champs sont remplis
            if(!empty($_POST['nom_utilisateur']) AND !empty($_POST['prenom_utilisateur']) 
            AND !empty($_POST['mail_utilisateur']) AND !empty($_POST['password_utilisateur']) 
            AND !empty($_POST['repeat_password_utilisateur'])){
                //Test si les mots de passe correspondent
                if($_POST['password_utilisateur']==$_POST['repeat_password_utilisateur']){
                    //setter les valeurs à l'objet UtilisateurController
                    $this->setNom(Utilitaire::cleanInput($_POST['nom_utilisateur']));
                    $this->setPrenom(Utilitaire::cleanInput($_POST['prenom_utilisateur']));
                    $this->setMail(Utilitaire::cleanInput($_POST['mail_utilisateur']));
                    //tester si le compte existe
                    if(!$this->findOneBy()){
                        //hashser le mot de passe
                        $this->setPassword(password_hash(Utilitaire::cleanInput($_POST['password_utilisateur']), PASSWORD_DEFAULT));
                        //Ajouter le compte en BDD
                        $this->add();
                        $error = "Le compte a été ajouté en BDD";
                    }    
                    else{
                        $error = "Le compte existe déja";
                    }
                }else{
                    $error = "Les mots de passe ne correspondent pas";
                }
            }else{
                $error = "Veuillez renseigner tous les champs du formulaire";
            }
        }
        include './App/Vue/vueAddUser.php';
    }
}
?>