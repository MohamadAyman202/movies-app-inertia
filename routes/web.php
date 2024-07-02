<?php

use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TrailerUrlController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Frontend\CastController as FrontendCastController;
use App\Http\Controllers\Frontend\EpisodeController as FrontendEpisodeController;
use App\Http\Controllers\Frontend\GenreController as FrontendGenreController;
use App\Http\Controllers\Frontend\MovieController as FrontendMovieController;
use App\Http\Controllers\Frontend\TagController as FrontendTagController;
use App\Http\Controllers\Frontend\TvShowController as FrontendTvShowController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/movies', [FrontendMovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie:slug}', [FrontendMovieController::class, 'show'])->name('movies.show');
Route::get('/tvShow', [FrontendTvShowController::class, 'index'])->name('tvShow.index');
Route::get('/tvShow/{tvShow:slug}', [FrontendTvShowController::class, 'show'])->name('tvShow.show');
Route::get('/tvShow/{tvShow:slug}/seasons/{season:slug}', [FrontendTvShowController::class, 'seasonShow'])->name('season.show');
Route::get('/episodes/{episode:slug}', [FrontendEpisodeController::class, 'showEpisode'])->name('episodes.show');
Route::get('/casts', [FrontendCastController::class, 'index'])->name('casts.index');
Route::get('/casts/{cast:slug}', [FrontendCastController::class, 'show'])->name('casts.show');
Route::get('/genre/{genre:slug}', [FrontendGenreController::class, 'show'])->name('genres.show');
Route::get('/tags/{tag:slug}', [FrontendTagController::class, 'show'])->name('tags.show');


Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Index');
    })->name('dashboard');

    Route::resource('movies', MovieController::class);
    Route::get('trailers/{movie}', [TrailerUrlController::class, 'index'])->name('trailers.index');
    Route::post('trailers/{movie}/store', [TrailerUrlController::class, 'store'])->name('trailers.store');
    Route::delete('trailers/{trailerUrl}/destroy', [TrailerUrlController::class, 'destroy'])->name('trailers.destroy');
    Route::resource('tv-show', TvShowController::class);

    Route::get('tv-show/{tv_show}/season', [SeasonController::class, 'index'])->name('season.index');
    Route::post('tv-show/{id}/seasons', [SeasonController::class, 'store'])->name('season.store');
    Route::get('tv-show/{tv_show_id}/seasons/edit/{season_id}', [SeasonController::class, 'edit'])->name('season.edit');
    Route::patch('tv-show/{tv_show_id}/seasons/update/{season_id}', [SeasonController::class, 'update'])->name('season.update');
    Route::delete('tv-show/seasons/{id}', [SeasonController::class, 'destroy'])->name('season.destroy');

    Route::get('tv-show/{tv_show}/season/{season}/episodes', [EpisodeController::class, 'index'])->name('episodes.index');
    Route::post('tv-show/{tv_show}/season/{season}/episodes/store', [EpisodeController::class, 'store'])->name('episodes.store');;
    Route::get('tv-show/{tv_show}/season/{season}/episodes/{id}/edit', [EpisodeController::class, 'edit'])->name('episodes.edit');
    Route::patch('tv-show/{tv_show}/season/{season}/episodes/{id}/update', [EpisodeController::class, 'update'])->name('episodes.update');;
    Route::delete('episodes/{id}/destroy', [EpisodeController::class, 'destroy'])->name('episodes.destroy');;

    Route::resource('genres', GenreController::class);
    Route::resource('casts', CastController::class);
    Route::resource('tags', TagController::class);
});

require __DIR__ . '/auth.php';
