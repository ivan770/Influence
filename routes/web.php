<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/logout_other', 'MiscController@LogoutOther')->name('logout_other');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tasks/{id}', 'TasksController@index')->name('tasks');

Route::get('/issues/{id}', 'IssuesController@index')->name('issues');

Route::get('/releases/{id}', 'ReleaseController@index')->name('releases');

Route::get('/messages/{id}', 'MessageController@index')->name('messages');

/* Project */

Route::post('/project/new', 'ProjectController@CreateNewProject')->name('new_project');

Route::post('/project/join', 'ProjectController@JoinProject')->name('join_project');

/* Tasks */

Route::post('/task/new', 'TasksController@CreateNewTask')->name('new_task');

Route::post('/task/status', 'TasksController@ChangeTaskStatus')->name('status_task');

Route::post('/task/delete', 'TasksController@DeleteTask')->name('delete_task');

/* Issues */

Route::post('/issue/new', 'IssuesController@CreateNewIssue')->name('new_issue');

Route::post('/issue/close', 'IssuesController@CloseIssue')->name('close_issue');

Route::post('/issue/delete', 'IssuesController@DeleteIssue')->name('delete_issue');

/* Releases */

Route::post('/release/new', 'ReleaseController@CreateNewRelease')->name('new_release');

Route::post('/release/delete', 'ReleaseController@DeleteRelease')->name('delete_release');

/* Messages */

Route::post('/message/new', 'MessageController@CreateNewMessage')->name('new_message');
