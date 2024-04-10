<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Utilisateur/Utilisateur.model.php");

class UtilisateurController extends MainController
{
    private $utilisateurManager;

    public function __construct()
    {
        $this->utilisateurManager = new UtilisateurManager();
    }

    public function validation_login($login, $password)
    {
        if ($this->utilisateurManager->isCombinaisonValide($login, $password)) {
            if ($this->utilisateurManager->estCompteActive($login)) {
                Toolbox::ajouterMessageAlerte("Bon retour sur le site " . $login . " !", Toolbox::COULEUR_VERTE);
                $_SESSION['profil'] = [
                    "login" => $login,
                ];
                header("location: " . URL . "compte/profil");
            } else {
                Toolbox::ajouterMessageAlerte("Le compte " . $login . " n'a pas été activé par mail", Toolbox::COULEUR_ROUGE);
                //renvoyer le mail de validation
                header("Location: " . URL . "login");
            }
        } else {
            Toolbox::ajouterMessageAlerte("Combinaison Login / Mot de passe non valide", Toolbox::COULEUR_ROUGE);
            header("Location: " . URL . "login");
        }
    }

    public function profil()
    {
        $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['login']);
        $_SESSION['profil']['role'] = $datas['role'];
        $data_page = [
            "page_description" => "Page de profil",
            "page_title" => "Page de profil",
            "utilisateur" => $datas,
            "view" => "views/Utilisateur/profil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function deconnexion()
    {
        Toolbox::ajouterMessageAlerte("La deconnecxion est effectuée", Toolbox::COULEUR_VERTE);
        unset($_SESSION['profil']);
        header("Location: " . URL . "accueil");
    }

    public function validation_creerCompte($login, $password, $mail)
    {
        if ($this->utilisateurManager->verifLoginDisponible($login)) {
            $passwordCrypte = password_hash($password, PASSWORD_DEFAULT);
            $clef = rand(0, 9999);
            if ($this->utilisateurManager->bdCreerCompte($login, $passwordCrypte, $mail, $clef)) {
                Toolbox::ajouterMessageAlerte("Le compte à bien été crée, un mail de validation vous à été envoyé !", Toolbox::COULEUR_VERTE);
                header("Location: " . URL . "login");
            } else {
                Toolbox::ajouterMessageAlerte("Erreur lors de la création du compte, recommencez !", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "creerCompte");
            }
        } else {
            Toolbox::ajouterMessageAlerte("Le login est déja utilisé !", Toolbox::COULEUR_ROUGE);
            header("Location: " . URL . "creerCompte");
        }
    }

    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
    }
}
