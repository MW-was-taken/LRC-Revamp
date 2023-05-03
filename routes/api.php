<?php
 
Route::group(['namespace' => 'Account', 'prefix' => 'account', 'middleware' => 'auth'], function() {
    Route::group(['prefix' => 'trades'], function() {
        Route::get('/inventory', 'TradesController@inventory');
        Route::post('/process', 'TradesController@process');
    });
});

Route::group(['prefix' => 'catalog'], function() {
    Route::get('/search', 'CatalogController@search');
});

Route::group(['prefix' => 'creator-area'], function() {
    Route::post('/render-preview', 'CreatorAreaController@renderPreview');
});

Route::group(['prefix' => 'groups'], function() {
    Route::get('/members', 'GroupsController@members');
    Route::get('/items', 'GroupsController@items');
    Route::get('/wall', 'GroupsController@wall');
    Route::post('/wall-post', 'GroupsController@wallPost');

    Route::group(['prefix' => 'manage', 'middleware' => 'auth'], function() {
        Route::post('/kick-member', 'GroupsController@kickMember');
        Route::post('/rank-member', 'GroupsController@rankMember');
        Route::post('/payout', 'GroupsController@payout');
    });
});

Route::group(['prefix' => 'search'], function() {
    Route::get('/all', 'SearchController@all');
});

Route::group(['prefix' => 'users'], function() {
    Route::get('/info', 'UsersController@info');
    Route::get('/inventory', 'UsersController@inventory');
});
