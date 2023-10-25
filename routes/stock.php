<?php

use Illuminate\Support\Facades\Route;

Route::post('/set', [StockController::class, 'store'])->name('set.store'); // создали колоду

Route::post('/create-flash-card', [StockController::class, 'create-flash-card'])->name('stock.flash.card'); // добавили слова в карточку
 
Route::get('/stock', [StockController::class, 'show'])->name('stock.show'); // нажали на кнопку учить словь открылась колода и подтянулись слова 



Schema::create('set', function (Blueprint $table) {
    $table->id();
    $table->timestamps();
    $table->integer('user_id');
    $table->string('name');
});



Schema::create('set-words', function (Blueprint $table) {
    $table->id();
    $table->timestamps();
    $table->integer('set_id');
    $table->string('word');
    $table->string('translate_word');
});

