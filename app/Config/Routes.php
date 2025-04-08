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
    $routes->post('/profile/update/profile', 'User::updateProfile');

    /* Trantor Technologies */
    $routes->get('/trantor-technologies', 'TrantorTechnologies::index');

    /* Quejas y Sugerencias */
    $routes->get('/quejas-sugerencias', 'Suggestion::index');
    $routes->post('/suggestion/create', 'Suggestion::createSuggestion');
    
    /* Documentos */
    $routes->get('/documentos', 'Documents::index');
    $routes->get('/documents/folder', 'Documents::getFolders');
    $routes->get('/documents/file/(:num)', 'Documents::getDocumentFiles/$1');

    /* TrantorInforma */
    $routes->get('/trantor-informa', 'TrantorInforma::index');
    $routes->get('/trantor-informa/text', 'TrantorInforma::getFeedText');
    $routes->get('/trantor-informa/image', 'TrantorInforma::getFeedImage');
    $routes->get('/trantor-informa/file', 'TrantorInforma::getFeedFile');

    $routes->post('/trantor-informa/like/add', 'TrantorInforma::newFeedLike');
    $routes->post('/trantor-informa/like/remove', 'TrantorInforma::removeFeedLike');
    $routes->post('/trantor-informa/comment/add', 'TrantorInforma::createComment');
    $routes->get('/trantor-informa/feed/comments/(:num)', 'TrantorInforma::getComments/$1');

    /* Directorio */
    $routes->get('/directorio', 'Directorio::index');

    /* Organization */
    $routes->get('/organization', 'Organization::index');
    $routes->get('/organization/data', 'Organization::getOrganization');
    $routes->get('/organization/data/department/(:num)', 'Organization::getOrganizationByDepartment/$1');
    
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
    
    /* Department */
    $routes->get('/department', 'Department::index');
    $routes->get('/department/new', 'Department::newDepartment');
    $routes->get('/department/edit/(:num)', 'Department::editDepartment/$1');
    $routes->post('/department/new', 'Department::createDepartment');
    $routes->post('/department/edit', 'Department::updateDepartment');
    $routes->post('/department/delete', 'Department::deleteDepartment');
    
    /* Documents */
    $routes->get('/documents', 'Documents::documents');
    $routes->post('/documents/folder/rename', 'Documents::updateFolder');
    $routes->post('/documents/folder/move', 'Documents::updateFolderParent');
    $routes->post('/documents/folder/create', 'Documents::newFolder');
    $routes->post('/documents/folder/delete', 'Documents::deleteFolder');
    $routes->post('/documents/file/create', 'Documents::createFile');
    $routes->post('/documents/file/delete', 'Documents::deleteFile');

    /* Files */
    $routes->post('/files/upload', 'Files::handleUpload');
    $routes->post('/files/upload/file', 'Files::handleUploadFile');
    $routes->delete('/files/revert', 'Files::handleDelete');

    /* TrantorInforma */
    $routes->post('/trantor-informa/new', 'TrantorInforma::store');
    $routes->post('/trantor-informa/delete', 'TrantorInforma::deleteFeed');
    $routes->post('/trantor-informa/update', 'TrantorInforma::updateFeed');
    $routes->post('/trantor-informa/comment/delete', 'TrantorInforma::deleteComment');

    /* Quejas y Sugerencias */
    $routes->get('/suggestions', 'Suggestion::adminIndex');
    $routes->get('/suggestions/get', 'Suggestion::getSuggestions');
    $routes->get('/suggestions/get/(:num)', 'Suggestion::getSuggestion/$1');
    $routes->post('/suggestions/unread', 'Suggestion::setStatusNew');
    $routes->post('/suggestions/read', 'Suggestion::setStatusOpen');
    $routes->post('/suggestions/delete', 'Suggestion::deleteSuggestion');
});