<?php

use App\Http\Controllers\Api\V1\StoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\V1\StateStoryController;

// Route::post('stories/create', [StoryController::class, 'create']);
// Route::put('stories/update/{id}', [StoryController::class, 'update']);
// Route::get('stories/get/{id}', [StoryController::class, 'find']);
// Route::get('stories/all', [StoryController::class, 'all']);
// Route::delete('stories/delete/{id}', [StoryController::class, 'delete']);

Route::resource('stories', StoryController::class);
Route::resource('states', StateController::class);
Route::resource('tags', TagController::class);
Route::resource('states.stories', StateStoryController::class);
Route::resource('tags.stories', StateStoryController::class);


// create => GET
// index => GET
// show => GET
// destroy => DELETE
// update => PUT
