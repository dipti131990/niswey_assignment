<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ContactController;

Route::get('/', [ContactController::class, 'index'])->name('import');
Route::get('/contact_list', [ContactController::class, 'getcontactList'])->name('contact.list');
Route::post('/import-xml', [ContactController::class, 'importXML'])->name('import.xml');
Route::post('/delete_contact', [ContactController::class, 'deleteContact'])->name('contact.delete');
Route::post('/save_contact', [ContactController::class, 'saveContact'])->name('contact.save');
