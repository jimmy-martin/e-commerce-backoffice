<?php

namespace App\Controllers;

class CoreController
{
    public function __construct()
    {
        // $match contient les infos sur la route courante
        global $match;

        // On aurait une erreur ci-dessous si $match vaut false car on ne peut pas lui demander une clé
        // Donc si $match est un booléen, on laisse ErrorController s'occuper de la route et il n'y a pas de droit à tester
        if (is_bool($match)) {
            // On sort de l'exécution du constructeur grace à return
            return;
        }

        // On récupère le nom de la route courante
        // On va se servir du nom de la route demandée pour la faire coïncider avec les ACL
        $routeName = $match['name'];

        // -----------------------------------
        // ACL
        // -----------------------------------

        $acl = [
            'main-home' => ['admin', 'catalog-manager'],

            'category-list' => ['admin', 'catalog-manager'],
            'category-add' => ['admin', 'catalog-manager'],
            'category-create' => ['admin', 'catalog-manager'],
            'category-update' => ['admin', 'catalog-manager'],
            'category-edit' => ['admin', 'catalog-manager'],
            'category-delete' => ['admin', 'catalog-manager'],

            'product-list' => ['admin', 'catalog-manager'],
            'product-add' => ['admin', 'catalog-manager'],
            'product-create' => ['admin', 'catalog-manager'],
            'product-update' => ['admin', 'catalog-manager'],
            'product-edit' => ['admin', 'catalog-manager'],
            'product-delete' => ['admin', 'catalog-manager'],

            // 'login-connect' => ['admin', 'catalog-manager'], // pas besoin de droits d'acces pour se connecter
            // 'login-authenticate' => ['admin', 'catalog-manager'], // pas besoin de droits d'acces pour se connecter
            'login-disconnect' => ['admin', 'catalog-manager'],

            'user-list' => ['admin'],
            'user-add' => ['admin'],
            'user-create' => ['admin'],
            'user-update' => ['admin'],
            'user-edit' => ['admin'],
            'user-delete' => ['admin'],
        ];

        // si je trouve le nom de la route dans mon tableau acl 
        if(array_key_exists($routeName, $acl)){
            // je recupere le tableau des roles autorisées
            $authorizedRoles = $acl[$routeName];

            // puis j'execute $this->checkAuthorization()
            $this->checkAuthorization($authorizedRoles);
        }
        // sinon on ne fait rien

        // ---------------------------------------------------
        // TOKEN ANTI-CSRF (attaque via faux formulaire)
        // ---------------------------------------------------

        // *****************************
        // partie dédiée aux formulaires
        // *****************************


        $csrfTokenToShowForm = [
            'user-add', // nom de la route
        ];

        if(in_array($routeName, $csrfTokenToShowForm)){
            // si ma route est présente dans le tableau $csrfTokenToCreate
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }

        // *****************************
        // partie dédiée aux traitement des formulaires
        // *****************************

        $csrfTokenToPostForm = [
            'user-create', // nom de la route
        ];

        if(in_array($routeName, $csrfTokenToPostForm)){
           // on recupere le token en session
           $token = filter_input(INPUT_POST, 'token');

           $sessionToken = $_SESSION['token'] ?? '';

           if ($token != $sessionToken || empty($token)){
               // si les token sont differents alors on affiche une 403
               http_response_code(403);
               $this->show('error/err403');
               exit;
           } else {
               // sinon on supprime le token et on laisse la suite du code s'exécuter
               unset($_SESSION['token']);
           }
        }
    }

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
