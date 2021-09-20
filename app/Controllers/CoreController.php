<?php

namespace App\Controllers;

class CoreController
{

    /**
     * Méthode permettant de vérifier les droits d'un utilisateur
     * - selon qu'il soit connecté, ou non
     * - selon son rôle
     * 
     * on l'autorise à voir la page
     * ou on le redirige, gentiment, ailleurs
     * 
     */
    public function checkAuthorization($roles = [])
    {
        if (isset($_SESSION['userObject'])) {
            //conecté

            $user = $_SESSION['userObject'];

            $userRole = $user->getRole();

            // je verifie si le role de l'utilisateur
            // fait partie des roles autorisées
            if (in_array($userRole, $roles)) {
                return true;
            } else {
                http_response_code(403);
                $this->show('error/err403');
                exit;
            }
        } else {
            // pas connecté

            global $router;
            header('Location: ' . $router->generate('login-connect'));
            exit;
        }
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // dump($viewData);

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
}
