<?php

use App\Http\Controllers\API\Article\ArticleController;
use App\Http\Controllers\API\Article\CategoryController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Conference\ConferenceController;
use App\Http\Controllers\API\Locale\LocaleController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\Organization\CityController;
use App\Http\Controllers\API\Organization\CountryController;
use App\Http\Controllers\API\Organization\OrganizationController;
use App\Http\Controllers\API\Organization\StructuralUnitController;
use App\Http\Controllers\API\OrganizerController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\PartnerController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\User\GrantController;
use App\Http\Controllers\API\User\PremiumController;
use App\Http\Controllers\API\User\ProjectController;
use App\Http\Controllers\API\User\SocialLinkController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserWorkController;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [ AuthController::class, 'login']);
    Route::post('register', [ AuthController::class, 'register']);
    Route::post('register-confirm', [ AuthController::class, 'registerConfirm']);
    Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [ AuthController::class, 'user']);
        Route::post('update', [ AuthController::class, 'update']);
        Route::post('update-photo', [ AuthController::class, 'updatePhoto']);
        Route::post('change-password', [ AuthController::class, 'changePassword']);
        Route::group(['prefix' => 'works'], function() {
            Route::get('/',[UserWorkController::class,'index']);
            Route::post('/', [UserWorkController::class,'create']);
            Route::post('/{work_id}', [UserWorkController::class,'update']);
            Route::delete('/{work_id}', [UserWorkController::class,'destroy']);
        });
        Route::group(['prefix' => 'grant'], function() {
            Route::get('/',[GrantController::class,'index']);
            Route::post('/',[GrantController::class,'store']);
            Route::post('/{grant_id}',[GrantController::class,'update']);
            Route::delete('/{grant_id}',[GrantController::class,'destroy']);
        });
        Route::group(['prefix' => 'project'], function() {
            Route::get('/',[ProjectController::class,'index']);
            Route::post('/',[ProjectController::class,'store']);
            Route::post('/{project_id}',[ProjectController::class,'update']);
            Route::delete('/{project_id}',[ProjectController::class,'destroy']);
        });
    });
    Route::post('logout', [ AuthController::class, 'logout'])->middleware('auth:sanctum');
});
Route::get('news',[NewsController::class, 'index']);
Route::get('organizers',[OrganizerController::class, 'index']);
Route::get('organizers/{organizer_id}',[OrganizerController::class, 'show']);
Route::get('partners',[PartnerController::class, 'index']);
Route::get('partners/{partner_id}',[PartnerController::class, 'show']);
Route::get('article-categories',[CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::get('users',[UserController::class, 'index']);
Route::post('users',[UserController::class, 'store']);
Route::get('users/{user_id}',[UserController::class, 'show']);
Route::get('users/{user_id}/statistics',[UserController::class,'statistics']);
Route::get('authors',[UserController::class, 'authors'])->middleware('auth:sanctum');
Route::get('/article', [ArticleController::class, 'index']);
Route::get('/article/{article_id}', [ArticleController::class, 'show']);
Route::group(['prefix' => 'article', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [ArticleController::class, 'store']);
    Route::post('/{article_id}', [ArticleController::class, 'update']);
    Route::delete('/{article_id}', [ArticleController::class, 'destroy']);
    Route::post('/{article_id}/approve', [ArticleController::class, 'approveAuthor']);
});
Route::group(['prefix' => 'organizations'], function () {
    Route::get('/', [OrganizationController::class,'index']);
    Route::get('/{organization_id}', [OrganizationController::class,'show']);
    Route::get('/{organization_id}/edit', [OrganizationController::class,'edit']);
    Route::post('/{organization_id}/update', [OrganizationController::class,'update']);
});
Route::group(['prefix' => 'structure-units'], static function () {
    Route::get('/',[StructuralUnitController::class,'index']);
    Route::post('/',[StructuralUnitController::class,'store']);
    Route::post('/{unit_id}',[StructuralUnitController::class,'update']);
    Route::delete('/{unit_id}',[StructuralUnitController::class,'destroy']);
});
Route::group(['prefix' => 'locales'], function () {
    Route::get('/',[LocaleController::class,'index']);
    Route::get('/active',[LocaleController::class,'getActive']);
    Route::post('/', [LocaleController::class, 'store']);
});
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/cities', [CityController::class, 'index']);

Route::group(['prefix' => 'conference'], function() {
    Route::get('/',[ConferenceController::class,'index']);
    Route::post('/', [ConferenceController::class,'store']);
    Route::get('/{conference_id}',[ConferenceController::class,'show']);
    Route::post('/{conference_id}', [ConferenceController::class,'update']);
    Route::delete('/{conference_id}', [ConferenceController::class,'destroy']);
    Route::post('/add-article/{conference}', [ConferenceController::class,'addArticle']);
    Route::post('/add-org-committee/{conference_id}', [ConferenceController::class,'addOrgCommittee']);
    Route::post('/remove-org-committee/{conference_id}', [ConferenceController::class,'removeOrgCommittee']);
    Route::post('/add-editors/{conference_id}', [ConferenceController::class,'addEditors']);
    Route::post('/remove-editors/{conference_id}', [ConferenceController::class,'removeEditors']);
});

Route::group(['prefix' => 'social-link', 'auth' => 'auth:sanctum'], static function () {
    Route::get('/',[SocialLinkController::class,'index']);
    Route::post('/',[SocialLinkController::class,'store']);
    Route::post('/{link_id}',[SocialLinkController::class,'update']);
    Route::delete('/{link_id}',[SocialLinkController::class,'destroy']);
});

Route::get('tags', [TagController::class, 'index']);
Route::get('/get-free-premium', [PremiumController::class, 'getFreePremium'])->middleware('auth:sanctum');

Route::get('/contact-info',[PageController::class,'contacts']);
Route::get('/rules-and-condition',[PageController::class,'rules']);
