<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->namespace('Api')->group(function () {
   Route::post('/login', 'AuthController@login');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::post('/logout', 'AuthController@logout');

    Route::apiResource('/projects', 'ProjectsController');
    Route::apiResource('/projects/{projectId}/issues', 'ProjectIssuesController');
    Route::apiResource('/issues', 'IssuesController');
    Route::apiResource('/comments', 'CommentsController');
    Route::apiResource('/files', 'FilesController');

    Route::get('/projects/{projectId}/userList', 'ProjectsController@getUserList');
    Route::get('/projects/{projectId}/assignedUsers', 'ProjectsController@getAssignedUsers');
    Route::post('/projects/{projectId}/assignedUsers', 'ProjectsController@postAssignedUsers');
    Route::delete('/projects/{projectId}/assignedUsers', 'ProjectsController@deleteAssignedUsers');
    Route::get('/issues/{issueId}/comments', 'IssueCommentsController@getIssueComments');
    Route::post('/issues/{issueId}/comments', 'IssueCommentsController@addIssueComment');
    Route::post('/issues/{issueId}/file', 'IssuesController@postAddFile');
    Route::delete('/issues/{issueId}/file/{fileId}', 'IssuesController@deleteFile');

    // Admin
    Route::middleware('is_admin')->group(function () {
        Route::apiResource('/admin/users', 'Admin\UsersController');
        Route::post('admin/users/{id}/generateNewPass', 'Admin\UsersController@generateNewPass');
    });
});
