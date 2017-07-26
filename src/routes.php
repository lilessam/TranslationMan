<?php
Route::group(['prefix' => config('translationman.url_prefix'), 'middleware' => config('translationman.middleware')], function(){

	Route::get('/newLang', 'Lilessam\\Translationman\\Controllers\\MainController@getNewLang')->name('translationman.getNewLang');
	Route::post('/newLang', 'Lilessam\\Translationman\\Controllers\\MainController@postNewLang')->name('translationman.postNewLang');
	Route::get('/newFile/{lang}', 'Lilessam\\Translationman\\Controllers\\MainController@getNewFile')->name('translationman.getNewFile');
	Route::post('/newFile/{lang}', 'Lilessam\\Translationman\\Controllers\\MainController@postNewFile')->name('translationman.postNewFile');


	//Delete
	Route::post('/deleteLang', 'Lilessam\\Translationman\\Controllers\\MainController@postDeleteLang')->name('translationman.postDeleteLang');
	Route::post('/deleteFile', 'Lilessam\\Translationman\\Controllers\\MainController@postDeleteFile')->name('translationman.postDeleteFile');

	Route::get('/', 'Lilessam\\Translationman\\Controllers\\MainController@index')->name('translationman.index');
	Route::get('/{lang}', 'Lilessam\\Translationman\\Controllers\\MainController@showLang')->name('translationman.langFiles');
	Route::get('/{lang}/{file}', 'Lilessam\\Translationman\\Controllers\\MainController@showFile')->name('translationman.langFileTranslations');
	Route::post('/{lang}/{file}', 'Lilessam\\Translationman\\Controllers\\MainController@saveFile')->name('translations.saveFile');

	
});
