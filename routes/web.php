<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// Authenticated API route group
$router->group(['middleware' => ['jwt.auth'], 'prefix'=>'api/auth' ], function () use ($router) {



});


/* Unauthenticated Routes */
$router->group(['prefix'=>'api'], function () use ($router) {
    $router->post('user/create', 'AuthController@createUser');
    $router->post('employee/create', 'EmployeesController@createEmployee');
    $router->post('employee/update', 'EmployeesController@updateEmployee');
    $router->post('login', 'AuthController@login');


    //TO BE ADDED TO AUTH ROUTES
    $router->post('create-department', 'DepartmentController@createDepartment');
    $router->get('all-departments', 'DepartmentController@allDepartments');

    $router->get('all-categories', 'CategoryController@allCategories');
    $router->post('create-category', 'CategoryController@createCategory');
    $router->post('employees/upload', 'EmployeesController@uploadDocument');


    $router->post('recommendations/create', 'RecommendationsController@createRecommendation');
    $router->get('recommendations/get/{period}', 'RecommendationsController@getRecommendations');
    $router->post('recommendations/schedule', 'RecommendationsController@addRecommendationToSchedule');

    $router->post('training-schedule/create', 'TrainingScheduleController@createSchedule');
    $router->get('training-schedule/get/{period}', 'TrainingScheduleController@getSchedules');
    $router->get('training-schedule/submitted/get/{period}', 'TrainingScheduleController@getSubmittedSchedules');
    $router->post('training-schedule/submit/', 'TrainingScheduleController@submitSchedule');
    $router->post('training-schedule/approved/create', 'TrainingScheduleController@createApprovedTraining');
    $router->post('training-schedule/approve', 'TrainingScheduleController@approveSchedule');
    $router->post('training-schedule/decline', 'TrainingScheduleController@declineSchedule');
    $router->post('training-schedule/update', 'TrainingScheduleController@updateSchedule');
    $router->get('training-schedule/approved/get/{period}', 'TrainingScheduleController@getApprovedSchedules');
    $router->get('training-schedule/completed/get/{period}', 'TrainingScheduleController@getCompletedSchedules');

    $router->post('nomination/create', 'NominationController@createNomination');
    $router->get('nomination/all-nominations', 'NominationController@getNominations');
    $router->get('nomination/nominations/{id}', 'NominationController@getNominationsById');
    $router->get('nomination/nominations/approve/{id}', 'NominationController@approveNomination');
    $router->get('nomination/nominations/decline/{id}', 'NominationController@declineNomination');

    $router->get('nomination/nominations/nominees/{id}', 'NominationController@getNominee');
    $router->post('nomination/participants/evaluate', 'NominationController@updateNominee');
    $router->post('trainings/upload', 'TrainingController@uploadDocument');

    $router->get('trainings/download/{id}', 'TrainingController@downloadFile');

    $router->get('permissions/all', 'PermissionController@getSystemPermissions');

    $router->get('years/', 'YearsController@getYears');

    $router->get('users', 'AuthController@allUsers');
    $router->get('employees', 'EmployeesController@allEmployees');





});
