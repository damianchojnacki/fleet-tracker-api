<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\OrganizationChatMessageController;
use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;
use Illuminate\Support\Facades\Route;

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
    return ['version' => config('app.version')];
})->name('homepage');

Route::get('docs/{path?}', DocsController::class)
    ->middleware(RestrictedDocsAccess::class)
    ->where('path', '(.*)')
    ->name('docs');

Route::apiResource('chat-messages', OrganizationChatMessageController::class)->only(['index']);
