<?php

// POINT D'ENTRÉE UNIQUE : 
// FrontController

/* ------------
---- DEBUG ----
-------------*/

// affiche toutes les erreurs
// 💀 environnement DEV uniquement
// 💀 à ne pas utiliser en PROD
@ini_set('display_errors', 1); // affiche les erreurs à l'écran
@ini_set('display_startup_errors', 1); // affiche les erreurs de démarrage PHP
@error_reporting(E_ALL); // affiche tous les types d'erreurs

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

// on cree une session (ou la restaure)
// on pourra donc se servir de la variable $_SESSION
session_start();

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va 
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
}
// sinon
else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// -----------------------------------------------
// HOME PAGE
// -----------------------------------------------

// On doit déclarer toutes les "routes" à AltoRouter, afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/',   // l'url à laquelle cette route réagit
    [
        'method' => 'home', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\MainController' // nom du controller contenant la méthode
    ],
    'main-home' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

// -----------------------------------------------
// CATÉGORIES
// -----------------------------------------------

$router->addRoutes([
    [
        'GET',
        '/category/list',
        [
            'method' => 'list',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-list'
    ],
    // Affichage formulaire ajout
    [
        'GET',
        '/category/add',
        [
            'method' => 'add',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-add'
    ],
    // Recuperation données formulaire ajout
    [
        'POST',
        '/category/add',
        [
            'method' => 'create',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-create'
    ],
    // Affichage formulaire update
    [
        'GET',
        '/category/update/[i:id]',
        [
            'method' => 'update',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-update'
    ],
    // Recuperation donnees formulaire update
    [
        'POST',
        '/category/update/[i:id]',
        [
            'method' => 'edit',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-edit'
    ],

    [
        'GET',
        '/category/delete/[i:id]',
        [
            'method' => 'delete',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-delete'
    ]
]);

// -----------------------------------------------
// PRODUITS
// -----------------------------------------------

$router->addRoutes([
    [
        'GET',
        '/product/list',
        [
            'method' => 'list',
            'controller' => '\App\Controllers\ProductController'
        ],
        'product-list'
    ],
    // Affichage formulaire ajout
    [
        'GET',
        '/product/add',
        [
            'method' => 'add',
            'controller' => '\App\Controllers\ProductController'
        ],
        'product-add'
    ],
    // Recuperation donnees formulaire ajout
    [
        'POST',
        '/product/add',
        [
            'method' => 'create',
            'controller' => '\App\Controllers\ProductController'
        ],
        'product-create'
    ],
    // Affichage formulaire update
    [
        'GET',
        '/product/update/[i:id]',
        [
            'method' => 'update',
            'controller' => '\App\Controllers\ProductController'
        ],
        'product-update'
    ],
    // Recuperation donnees formulaire update
    [
        'POST',
        '/product/update/[i:id]',
        [
            'method' => 'edit',
            'controller' => '\App\Controllers\ProductController'
        ],
        'product-edit'
    ],

    [
        'GET',
        '/product/delete/[i:id]',
        [
            'method' => 'delete',
            'controller' => '\App\Controllers\ProductController'
        ],
        'product-delete'
    ]
]);

// -----------------------------------------------
// MARQUES
// -----------------------------------------------

// -----------------------------------------------
// TYPES
// -----------------------------------------------

// -----------------------------------------------
// ORDER HOME CATEGORIES
// -----------------------------------------------

$router->addRoutes([
    [
        'GET',
        '/category/order',
        [
            'method' => 'order',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-order'
    ],

    [
        'POST',
        '/category/order',
        [
            'method' => 'changeOrder',
            'controller' => '\App\Controllers\CategoryController'
        ],
        'category-changeOrder'
    ]
]);

// -----------------------------------------------
// CONNEXION
// -----------------------------------------------

$router->addRoutes([
    [
        'GET',
        '/login',
        [
            'method' => 'connect',
            'controller' => '\App\Controllers\LoginController'
        ],
        'login-connect'
    ],

    [
        'POST',
        '/login',
        [
            'method' => 'authenticate',
            'controller' => '\App\Controllers\LoginController'
        ],
        'login-authenticate'
    ],

    [
        'GET',
        '/logout',
        [
            'method' => 'disconnect',
            'controller' => '\App\Controllers\LoginController'
        ],
        'login-disconnect'
    ],
]);

// -----------------------------------------------
// UTILISATEURS
// -----------------------------------------------

$router->addRoutes([
    [
        'GET',
        '/user/list',
        [
            'method' => 'list',
            'controller' => '\App\Controllers\UserController'
        ],
        'user-list'
    ],

    [
        'GET',
        '/user/add',
        [
            'method' => 'add',
            'controller' => '\App\Controllers\UserController'
        ],
        'user-add'
    ],

    [
        'POST',
        '/user/add',
        [
            'method' => 'create',
            'controller' => '\App\Controllers\UserController'
        ],
        'user-create'
    ],

    [
        'GET',
        '/user/update/[i:id]',
        [
            'method' => 'update',
            'controller' => '\App\Controllers\UserController'
        ],
        'user-update'
    ],

    [
        'POST',
        '/user/update/[i:id]',
        [
            'method' => 'edit',
            'controller' => '\App\Controllers\UserController'
        ],
        'user-edit'
    ],

    [
        'GET',
        '/user/delete/[i:id]',
        [
            'method' => 'delete',
            'controller' => '\App\Controllers\UserController'
        ],
        'user-delete'
    ]
]);

/* -------------
--- DISPATCH ---
--------------*/
// https://github.com/benoclock/AltoDispatcher
// https://packagist.org/packages/benoclock/alto-dispatcher

// on demande à (alto)$router
// s'il trouve ($match) la route de notre URL actuelle
$match = $router->match(); // return false, si aucune route correspondante
// on envoie le résultat du $match au dispatcher
// accompagné d'un plan B (fallback) : une belle erreur 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// puis on lance le dispatcher
$dispatcher->dispatch();
