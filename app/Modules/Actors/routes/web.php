<?php

use App\Modules\Actors\Http\Controllers\{
    ActorsController,
    ManageActorController,
    BucketController
};
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::get('actors', [ActorsController::class, 'listActors'])->name('admin.actors');
    Route::get('actors/{id}/detail', [ActorsController::class, 'actorDetail'])->name('admin.actors.detail');
    Route::get('actors/{id}/video', [ActorsController::class, 'actorVideo'])->name('admin.actors.video');
    Route::get('list-actors', [ManageActorController::class, 'ActorList'])->name('admin.actors.mange');
    Route::get('list-actors/create', [ManageActorController::class, 'ActorCreate'])->name('admin.actors.mange.create');
    Route::post('list-actors/store', [ManageActorController::class, 'ActorStroe'])->name('admin.actors.mange.store');
    Route::get('list-actors/{id}/edit', [ManageActorController::class, 'ActorEdit'])->name('admin.actors.mange.edit');
    Route::post('list-actors/{id}/update', [ManageActorController::class, 'ActorUpdate'])->name('admin.actors.mange.update');
    Route::get('list-actors/{id}/delete', [ManageActorController::class, 'ActorDelete'])->name('admin.actors.mange.delete');
    Route::get('list-actors/{id}/delete', [ManageActorController::class, 'ActorDelete'])->name('admin.actors.mange.delete');
    Route::post('bucket-actors/store',[BucketController::class,'store'])->name('admin.actors.bucket.store');
});
