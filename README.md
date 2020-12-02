# languageSupport
For multilanguage apps, allows the use in front end of language files like the ones in laravel.
Made with vanilla php & js.

## With Laravel:

- Add *languageSupport.php* file to app/support.
 - Add a language field to the users table.

- Then create a folder under '*resources/lang*' (for example *vendor/vue*), then another folder inside for each language ( *en*, *es*...).
In each language folder, add php files (for example '*errors.php*'):


>     <?php
>
>         return [
>          'hello' => 'Hola',
>          'bye' => 'Adiós!!'
>          ];

- In web.php add:

>      Route::get('/language', function () {
>     	    return	response()->streamDownload(function () {
>     				$data= languageSupport::jsObject('vendor/vue/'.auth()->user()->language);
>      				$function= languageSupport::jsFunction();
>       				echo "$function $data";
>      		});
>      });
This will send an object with all translations and the js function *__l(file,key)* to front.
- In wrapping blade (views/app.blade.php) add:
>
>
> `<script src="/language"></script>`

Now in front, if there was an *errors.php* in '*es*' folder and user had '*es*' language, when called **__l('errors','hello')** the output is '*Hola*'.



## Miscellany


If *languageSupport.php* is in a different folder change its namespace and attribute *$basepath*. This attribute defines the path to *resources/lang*.
Laravel's *resource_path()* can't be used because a static attribute can't be initialized with a function call. It's static because static methods can only use static attributes.


**__l(‘errors’,‘hello’)** returns the key ('hello' in this case) when file ('errors') or key ('hello') don't exist.

## TODO
- Allow parameters to complete parts of a translation (like numbers).
- Allow singular and plural depending on a number passed (like "day left|days left").

