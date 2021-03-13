<?php

use Illuminate\Support\Facades\Route;

Route::resource('metadata', 'Metadata\MetadataController')->only(['store', 'update']);

Route::get('metadata/{metadata}', 'Metadata\MetadataDataController@index')->name('metadata.data.index');
Route::get('metadata/{metadata}/data/{data}', 'Metadata\MetadataDataController@show')->name('metadata.data.show');
Route::post('metadata/{metadata}', 'Metadata\MetadataDataController@store')->name('metadata.data.store');
Route::put('metadata/{metadata}/data/{data}', 'Metadata\MetadataDataController@update')->name('metadata.data.update');
Route::delete('metadata/{metadata}/data/{data}', 'Metadata\MetadataDataController@destroy')->name('metadata.data.destroy');
