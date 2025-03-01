<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
*/

/**************************************
 * FUERA DE FILTRO DE AUTENTICACIÓN
***************************************/
$routes->group('', function($routes) {

    /* Auth */
    $routes->get('/', 'Auth::index');
    $routes->post('/auth/login', 'Auth::login');

});

/**************************************
 * ROL USUARIO Y ADMINISTRADOR
***************************************/
$routes->group('', ['filter' => 'auth:admin,user'], function($routes) {

    /* Auth */
    $routes->get('/auth/logout', 'Auth::logout');

    /* Alerts */
    $routes->get('/alerts', 'Alert::index');
    $routes->get('/alerts/unread', 'Alert::getUnreadAlerts');
    $routes->post('/alerts/read/(:num)', 'Alert::markAlertAsRead/$1');

    /* Profile */
    $routes->get('/profile', 'User::profile');
    $routes->post('/profile/update/password', 'User::updatePassword');
    $routes->post('/profile/update/photo', 'User::updatePhoto');

    /* Trantor Technologies */
    $routes->get('/trantor-technologies', 'TrantorTechnologies::index');

    /* Quejas y Sugerencias */
    $routes->get('/quejas-sugerencias', 'QuejasSugerencias::index');
    
    /* Documentos */
    $routes->get('/documentos', 'Documents::index');

    /* TrantorInforma */
    $routes->get('/trantor-informa', 'TrantorInforma::index');

    $routes->post('/trantor-informa/like/add', 'TrantorInforma::newFeedLike');
    $routes->post('/trantor-informa/like/remove', 'TrantorInforma::removeFeedLike');
    $routes->post('/trantor-informa/comment/add', 'TrantorInforma::createComment');
    $routes->get('/trantor-informa/feed/comments/(:num)', 'TrantorInforma::getComments/$1');
    
});

/**************************************
 * ADMINISTRADOR
***************************************/
$routes->group('', ['filter' => 'auth:admin'], function($routes) {
    
    /* Auth */
    $routes->post('/auth/register', 'Auth::register');
    $routes->post('/auth/user/update', 'Auth::updateUser');
    $routes->post('/auth/user/active', 'Auth::activeUser');
    $routes->post('/auth/user/inactive', 'Auth::inactiveUser');
    
    /* Users */
    $routes->get('/user', 'User::index');
    $routes->get('/user/new', 'User::newUser');
    $routes->get('/user/edit/(:num)', 'User::editUser/$1');

    /* Ocupation */
    $routes->get('/ocupation', 'Ocupation::index');
    $routes->get('/ocupation/new', 'Ocupation::newOcupation');
    $routes->get('/ocupation/edit/(:num)', 'Ocupation::editOcupation/$1');
    $routes->post('/ocupation/new', 'Ocupation::createOcupation');
    $routes->post('/ocupation/edit', 'Ocupation::updateOcupation');
    $routes->post('/ocupation/delete', 'Ocupation::deleteOcupation');
    
    /* Organization */
    $routes->get('/organization', 'Organization::index');
    
    /* Documents */
    $routes->get('/documents', 'Documents::documents');

     /* Files */
    $routes->post('/files/upload', 'Files::handleUpload');
    $routes->post('/files/upload/file', 'Files::handleUploadFile');
    $routes->delete('/files/revert', 'Files::handleDelete');

     /* TrantorInforma */
    $routes->post('/trantor-informa/new', 'TrantorInforma::store');
    
});