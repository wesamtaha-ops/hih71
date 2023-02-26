<?php

namespace PHPMaker2023\hih71;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Slim\Exception\HttpNotFoundException;

// Handle Routes
return function (App $app) {
    // countries
    $app->map(["GET","POST","OPTIONS"], '/CountriesList[/{id}]', CountriesController::class . ':list')->add(PermissionMiddleware::class)->setName('CountriesList-countries-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/CountriesAdd[/{id}]', CountriesController::class . ':add')->add(PermissionMiddleware::class)->setName('CountriesAdd-countries-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/CountriesView[/{id}]', CountriesController::class . ':view')->add(PermissionMiddleware::class)->setName('CountriesView-countries-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/CountriesEdit[/{id}]', CountriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('CountriesEdit-countries-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/CountriesDelete[/{id}]', CountriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('CountriesDelete-countries-delete'); // delete
    $app->group(
        '/countries',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', CountriesController::class . ':list')->add(PermissionMiddleware::class)->setName('countries/list-countries-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', CountriesController::class . ':add')->add(PermissionMiddleware::class)->setName('countries/add-countries-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', CountriesController::class . ':view')->add(PermissionMiddleware::class)->setName('countries/view-countries-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', CountriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('countries/edit-countries-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', CountriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('countries/delete-countries-delete-2'); // delete
        }
    );

    // curriculums
    $app->map(["GET","POST","OPTIONS"], '/CurriculumsList[/{id}]', CurriculumsController::class . ':list')->add(PermissionMiddleware::class)->setName('CurriculumsList-curriculums-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/CurriculumsAdd[/{id}]', CurriculumsController::class . ':add')->add(PermissionMiddleware::class)->setName('CurriculumsAdd-curriculums-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/CurriculumsView[/{id}]', CurriculumsController::class . ':view')->add(PermissionMiddleware::class)->setName('CurriculumsView-curriculums-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/CurriculumsEdit[/{id}]', CurriculumsController::class . ':edit')->add(PermissionMiddleware::class)->setName('CurriculumsEdit-curriculums-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/CurriculumsDelete[/{id}]', CurriculumsController::class . ':delete')->add(PermissionMiddleware::class)->setName('CurriculumsDelete-curriculums-delete'); // delete
    $app->group(
        '/curriculums',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', CurriculumsController::class . ':list')->add(PermissionMiddleware::class)->setName('curriculums/list-curriculums-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', CurriculumsController::class . ':add')->add(PermissionMiddleware::class)->setName('curriculums/add-curriculums-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', CurriculumsController::class . ':view')->add(PermissionMiddleware::class)->setName('curriculums/view-curriculums-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', CurriculumsController::class . ':edit')->add(PermissionMiddleware::class)->setName('curriculums/edit-curriculums-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', CurriculumsController::class . ':delete')->add(PermissionMiddleware::class)->setName('curriculums/delete-curriculums-delete-2'); // delete
        }
    );

    // currencies
    $app->map(["GET","POST","OPTIONS"], '/CurrenciesList[/{id}]', CurrenciesController::class . ':list')->add(PermissionMiddleware::class)->setName('CurrenciesList-currencies-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/CurrenciesAdd[/{id}]', CurrenciesController::class . ':add')->add(PermissionMiddleware::class)->setName('CurrenciesAdd-currencies-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/CurrenciesView[/{id}]', CurrenciesController::class . ':view')->add(PermissionMiddleware::class)->setName('CurrenciesView-currencies-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/CurrenciesEdit[/{id}]', CurrenciesController::class . ':edit')->add(PermissionMiddleware::class)->setName('CurrenciesEdit-currencies-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/CurrenciesDelete[/{id}]', CurrenciesController::class . ':delete')->add(PermissionMiddleware::class)->setName('CurrenciesDelete-currencies-delete'); // delete
    $app->group(
        '/currencies',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', CurrenciesController::class . ':list')->add(PermissionMiddleware::class)->setName('currencies/list-currencies-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', CurrenciesController::class . ':add')->add(PermissionMiddleware::class)->setName('currencies/add-currencies-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', CurrenciesController::class . ':view')->add(PermissionMiddleware::class)->setName('currencies/view-currencies-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', CurrenciesController::class . ':edit')->add(PermissionMiddleware::class)->setName('currencies/edit-currencies-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', CurrenciesController::class . ':delete')->add(PermissionMiddleware::class)->setName('currencies/delete-currencies-delete-2'); // delete
        }
    );

    // languages
    $app->map(["GET","POST","OPTIONS"], '/LanguagesList[/{id}]', LanguagesController::class . ':list')->add(PermissionMiddleware::class)->setName('LanguagesList-languages-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/LanguagesAdd[/{id}]', LanguagesController::class . ':add')->add(PermissionMiddleware::class)->setName('LanguagesAdd-languages-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/LanguagesView[/{id}]', LanguagesController::class . ':view')->add(PermissionMiddleware::class)->setName('LanguagesView-languages-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/LanguagesEdit[/{id}]', LanguagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('LanguagesEdit-languages-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/LanguagesDelete[/{id}]', LanguagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('LanguagesDelete-languages-delete'); // delete
    $app->group(
        '/languages',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', LanguagesController::class . ':list')->add(PermissionMiddleware::class)->setName('languages/list-languages-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', LanguagesController::class . ':add')->add(PermissionMiddleware::class)->setName('languages/add-languages-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', LanguagesController::class . ':view')->add(PermissionMiddleware::class)->setName('languages/view-languages-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', LanguagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('languages/edit-languages-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', LanguagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('languages/delete-languages-delete-2'); // delete
        }
    );

    // languages_levels
    $app->map(["GET","POST","OPTIONS"], '/LanguagesLevelsList[/{id}]', LanguagesLevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('LanguagesLevelsList-languages_levels-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/LanguagesLevelsAdd[/{id}]', LanguagesLevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('LanguagesLevelsAdd-languages_levels-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/LanguagesLevelsView[/{id}]', LanguagesLevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('LanguagesLevelsView-languages_levels-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/LanguagesLevelsEdit[/{id}]', LanguagesLevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('LanguagesLevelsEdit-languages_levels-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/LanguagesLevelsDelete[/{id}]', LanguagesLevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('LanguagesLevelsDelete-languages_levels-delete'); // delete
    $app->group(
        '/languages_levels',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', LanguagesLevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('languages_levels/list-languages_levels-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', LanguagesLevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('languages_levels/add-languages_levels-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', LanguagesLevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('languages_levels/view-languages_levels-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', LanguagesLevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('languages_levels/edit-languages_levels-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', LanguagesLevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('languages_levels/delete-languages_levels-delete-2'); // delete
        }
    );

    // levels
    $app->map(["GET","POST","OPTIONS"], '/LevelsList[/{id}]', LevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('LevelsList-levels-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/LevelsAdd[/{id}]', LevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('LevelsAdd-levels-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/LevelsView[/{id}]', LevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('LevelsView-levels-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/LevelsEdit[/{id}]', LevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('LevelsEdit-levels-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/LevelsDelete[/{id}]', LevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('LevelsDelete-levels-delete'); // delete
    $app->group(
        '/levels',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', LevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('levels/list-levels-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', LevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('levels/add-levels-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', LevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('levels/view-levels-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', LevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('levels/edit-levels-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', LevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('levels/delete-levels-delete-2'); // delete
        }
    );

    // orders
    $app->map(["GET","POST","OPTIONS"], '/OrdersList[/{id}]', OrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('OrdersList-orders-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/OrdersAdd[/{id}]', OrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('OrdersAdd-orders-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/OrdersView[/{id}]', OrdersController::class . ':view')->add(PermissionMiddleware::class)->setName('OrdersView-orders-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/OrdersEdit[/{id}]', OrdersController::class . ':edit')->add(PermissionMiddleware::class)->setName('OrdersEdit-orders-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/OrdersDelete[/{id}]', OrdersController::class . ':delete')->add(PermissionMiddleware::class)->setName('OrdersDelete-orders-delete'); // delete
    $app->group(
        '/orders',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', OrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('orders/list-orders-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', OrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('orders/add-orders-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', OrdersController::class . ':view')->add(PermissionMiddleware::class)->setName('orders/view-orders-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', OrdersController::class . ':edit')->add(PermissionMiddleware::class)->setName('orders/edit-orders-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', OrdersController::class . ':delete')->add(PermissionMiddleware::class)->setName('orders/delete-orders-delete-2'); // delete
        }
    );

    // topics
    $app->map(["GET","POST","OPTIONS"], '/TopicsList[/{id}]', TopicsController::class . ':list')->add(PermissionMiddleware::class)->setName('TopicsList-topics-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TopicsAdd[/{id}]', TopicsController::class . ':add')->add(PermissionMiddleware::class)->setName('TopicsAdd-topics-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/TopicsView[/{id}]', TopicsController::class . ':view')->add(PermissionMiddleware::class)->setName('TopicsView-topics-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/TopicsEdit[/{id}]', TopicsController::class . ':edit')->add(PermissionMiddleware::class)->setName('TopicsEdit-topics-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/TopicsDelete[/{id}]', TopicsController::class . ':delete')->add(PermissionMiddleware::class)->setName('TopicsDelete-topics-delete'); // delete
    $app->group(
        '/topics',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', TopicsController::class . ':list')->add(PermissionMiddleware::class)->setName('topics/list-topics-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', TopicsController::class . ':add')->add(PermissionMiddleware::class)->setName('topics/add-topics-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', TopicsController::class . ':view')->add(PermissionMiddleware::class)->setName('topics/view-topics-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', TopicsController::class . ':edit')->add(PermissionMiddleware::class)->setName('topics/edit-topics-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', TopicsController::class . ':delete')->add(PermissionMiddleware::class)->setName('topics/delete-topics-delete-2'); // delete
        }
    );

    // transfers
    $app->map(["GET","POST","OPTIONS"], '/TransfersList[/{id}]', TransfersController::class . ':list')->add(PermissionMiddleware::class)->setName('TransfersList-transfers-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TransfersAdd[/{id}]', TransfersController::class . ':add')->add(PermissionMiddleware::class)->setName('TransfersAdd-transfers-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/TransfersView[/{id}]', TransfersController::class . ':view')->add(PermissionMiddleware::class)->setName('TransfersView-transfers-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/TransfersEdit[/{id}]', TransfersController::class . ':edit')->add(PermissionMiddleware::class)->setName('TransfersEdit-transfers-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/TransfersDelete[/{id}]', TransfersController::class . ':delete')->add(PermissionMiddleware::class)->setName('TransfersDelete-transfers-delete'); // delete
    $app->group(
        '/transfers',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', TransfersController::class . ':list')->add(PermissionMiddleware::class)->setName('transfers/list-transfers-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', TransfersController::class . ':add')->add(PermissionMiddleware::class)->setName('transfers/add-transfers-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', TransfersController::class . ':view')->add(PermissionMiddleware::class)->setName('transfers/view-transfers-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', TransfersController::class . ':edit')->add(PermissionMiddleware::class)->setName('transfers/edit-transfers-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', TransfersController::class . ':delete')->add(PermissionMiddleware::class)->setName('transfers/delete-transfers-delete-2'); // delete
        }
    );

    // users
    $app->map(["GET","POST","OPTIONS"], '/UsersList[/{id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('UsersList-users-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UsersAdd[/{id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('UsersAdd-users-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/UsersView[/{id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('UsersView-users-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UsersEdit[/{id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('UsersEdit-users-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UsersDelete[/{id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('UsersDelete-users-delete'); // delete
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
        }
    );

    // login
    $app->map(["GET","POST","OPTIONS"], '/login[/{provider}]', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // logout
    $app->map(["GET","POST","OPTIONS"], '/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->get('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        if (Route_Action($app) === false) {
            return;
        }
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            throw new HttpNotFoundException($request, str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")));
        }
    );
};
