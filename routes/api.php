<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('me', 'User\MeController@getMe');

// Team
Route::get('teams/slug/{slug}', 'Teams\TeamsController@findBySlug');
Route::get('teams/{id}/designs', 'Designs\DesignController@getForTeam');

// Search Designs
Route::get('search/designs', 'Designs\DesignController@search');
Route::get('search/designers', 'User\UserController@search');

// Route group for authenticated users only
Route::group(['middleware' => ['auth:api']], function(){
    Route::post('logout', 'Auth\LoginController@logout');
    Route::put('settings/profile', 'User\SettingsController@updateProfile');
    Route::put('settings/password', 'User\SettingsController@updatePassword');

    //users
    Route::get('users', 'User\UserController@index');
    Route::get('user/{username}', 'User\UserController@findByUsername');
    Route::get('users/{id}/designs', 'Designs\DesignController@getForUser');

    // Clientes
    Route::get('clientes', 'Clientes\ClienteController@index');
    Route::get('clientes/{id}', 'Clientes\ClienteController@findCliente');
    Route::post('clientes', 'Clientes\ClienteController@cadastra');
    Route::put('clientes/{id}', 'Clientes\ClienteController@atualiza');
    Route::delete('clientes/{id}', 'Clientes\ClienteController@deleta');

    // Ordens
    Route::get('ordens', 'Ordens\OrdemController@index');
    Route::get('ordens/{id}', 'Ordens\OrdemController@findOrdem');
    Route::get('ordens/{id}/pdf', 'Ordens\PdfController@pdfOrdem');
    Route::post('ordens', 'Ordens\OrdemController@cadastra');
    Route::put('ordens/{id}', 'Ordens\OrdemController@atualiza');
    Route::delete('ordens/{id}', 'Ordens\OrdemController@deleta');

    // Likes and Unlikes
    Route::post('designs/{id}/like', 'Designs\DesignController@like');
    Route::get('designs/{id}/liked', 'Designs\DesignController@checkIfUserHasLiked');

    // Comments
    Route::post('designs/{id}/comments', 'Designs\CommentController@store');
    Route::put('comments/{id}', 'Designs\CommentController@update');
    Route::delete('comments/{id}', 'Designs\CommentController@destroy');

    // Teams
    Route::post('teams', 'Teams\TeamsController@store');
    Route::get('teams/{id}', 'Teams\TeamsController@findById');
    Route::get('teams', 'Teams\TeamsController@index');
    Route::get('users/teams', 'Teams\TeamsController@fetchUserTeams');
    Route::put('teams/{id}', 'Teams\TeamsController@update');
    Route::delete('teams/{id}', 'Teams\TeamsController@destroy');
    Route::delete('teams/{team_id}/users/{user_id}', 'Teams\TeamsController@removeFromTeam');
    
    // Invitations
    Route::post('invitations/{teamId}', 'Teams\InvitationsController@invite');
    Route::post('invitations/{id}/resend', 'Teams\InvitationsController@resend');
    Route::post('invitations/{id}/respond', 'Teams\InvitationsController@respond');
    Route::delete('invitations/{id}', 'Teams\InvitationsController@destroy');

    // Chats
    Route::post('chats', 'Chats\ChatController@sendMessage');
    Route::get('chats', 'Chats\ChatController@getUserChats');
    Route::get('chats/{id}/messages', 'Chats\ChatController@getChatMessages');
    Route::put('chats/{id}/markAsRead', 'Chats\ChatController@markAsRead');
    Route::delete('messages/{id}', 'Chats\ChatController@destroyMessage');
    
});

// Routes for guests only
Route::group(['middleware' => ['guest:api']], function(){
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    


});