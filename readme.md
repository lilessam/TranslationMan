### TranslationMan Package For Laravel
This small package give you all functionlaity you need to manage your laravel language files with simple forms you can integrate in your application layout.
#### Features
1. Lanaguages Creation/Deletion.
2. Language Files Creation/Deletion.
3. Files' array modification with a simple form (Allows multi dimensional arrays with dots in the index column).
#### Installation
Via Composer `composer require lilessam/translationman`

Add `Lilessam\Translationman\TranslationmanServiceProvider::class` to your providers array in `config/app.php`. 

You will also have to set `resources/lang` folder permissions to 777.
#### Publish Config and Views
`php artisan vendor:publish --provider=Lilessam\Translationman\TranslationmanServiceProvider`
Now views files will be published in `resources/views/vendor/translationman`.

You will realize that all files contains only basic bootstrap forms. You will have to integrate this forms as you like.
#### Routes
When you publish the service provider files you will see `translationman.php` file in `Config` folder. So there you can `url_prefix`. Default is `translations` so it can be viewed by `app.dev/translations`.

You can also provide a middleware for the package routes by modifying `middleware` in the config file.

The `middleware` can be string or an array of middlewares (BUT CANNOT BE EMPTY STRING).

###### Notice: All package views are pure Bootstrap forms and tables without any CSS. You have to integrate views files into your application theme by extending your layouts.