<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Visiteur/Visiteur.model.php");

class VisiteurController extends MainController
{

    private $visiteurManager;

    public function __construct()
    {
        $this->visiteurManager = new VisiteurManager();
    }

    public function accueil()
    {
        // echo password_hash("...", PASSWORD_DEFAULT);

        $utilisateurs = $this->visiteurManager->getUtilisateurs();
        // print_r($utilisateurs);

        $data_page = [
            "page_description" => "Description de la page d'accueil",
            "page_title" => "Titre de la page d'accueil",
            "utilisateurs" => $utilisateurs,
            "view" => "views/Visiteur/accueil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
    }
}
