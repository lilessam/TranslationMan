<?php
Route::group(['prefix' => config('translationman.url_prefix'), 'middleware' => config('translationman.middleware')], function(){

	Route::get('/newLang', 'MainController@getNewLang')->name('translationman.getNewLang');
	Route::post('/newLang', 'MainController@postNewLang')->name('translationman.postNewLang');
	Route::get('/newFile/{lang}', 'MainController@getNewFile')->name('translationman.getNewFile');
	Route::post('/newFile/{lang}', 'MainController@postNewFile')->name('translationman.postNewFile');


	//Delete
	Route::post('/deleteLang', 'MainController@postDeleteLang')->name('translationman.postDeleteLang');
	Route::post('/deleteFile', 'MainController@postDeleteFile')->name('translationman.postDeleteFile');

	Route::get('/', 'MainController@index')->name('translationman.index');
	Route::get('/{lang}', 'MainController@showLang')->name('translationman.langFiles');
	Route::get('/{lang}/{file}', 'MainController@showFile')->name('translationman.langFileTranslations');
	Route::post('/{lang}/{file}', 'MainController@saveFile')->name('translations.saveFile');

	
});
