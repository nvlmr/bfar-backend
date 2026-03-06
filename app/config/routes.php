<?php
// app/config/routes.php

$router = new Router();

$router->get('/', 'Home@index'); 

$router->get('/login', 'Auth@loginForm');
$router->post('/login', 'Auth@login');
$router->get('/logout', 'Auth@logout');

$router->get('/superadmin/dashboard', 'Dashboard@superAdmin');
$router->get('/superadmin/users', 'Dashboard@users');
$router->get('/superadmin/admins', 'Dashboard@admins');
$router->post('/superadmin/user/toggle', 'Dashboard@toggleUser');
$router->get('/superadmin/register', 'Dashboard@registerAdminForm');
$router->post('/superadmin/register', 'Dashboard@registerAdmin');

$router->get('/forgot-password', 'Auth@forgotForm');
$router->post('/forgot-password', 'Auth@sendResetLink');

$router->get('/reset-password', 'Auth@resetForm');
$router->post('/reset-password', 'Auth@resetPassword');

$router->get('/register', 'Auth@registerForm');
$router->post('/register', 'Auth@register');

$router->get('/admin/dashboard', 'Dashboard@admin');

/*
|--------------------------------------------------------------------------
| RESEARCH TEAM
|--------------------------------------------------------------------------
*/


$router->get('/admin/research-team', 'ResearchTeamController@index');
$router->get('/admin/research-team/create', 'ResearchTeamController@create');
$router->post('/admin/research-team/store', 'ResearchTeamController@store');
$router->get('/admin/research-team/edit/(:num)', 'ResearchTeamController@edit');
$router->post('/admin/research-team/update/(:num)', 'ResearchTeamController@update');
$router->post('/admin/research-team/delete', 'ResearchTeamController@delete');
$router->post('/admin/research-team/publish', 'ResearchTeamController@publish');
$router->post('/admin/research-team/draft', 'ResearchTeamController@draft');

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
*/
$router->get('/api/research-team', 'ApiController@getResearchTeam');
$router->get('/api/research-team/(:num)', 'ApiController@getResearcher');
$router->get('/api/projects', 'ApiController@getProjects');
$router->get('/api/publications', 'ApiController@getPublications');