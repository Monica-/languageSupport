<?php


namespace App\support;

class languageSupport
{
    private static $basePath = __DIR__.'/../../resources/lang/';

    /**
     * @param $path  (from $basePath)
     * @return false|string
     */
    public static function jsonObject($path)
    {
        $object = self::phpObject($path);

        return json_encode($object);
    }

    public static function jsObject($path)
    {
        $object = self::phpObject($path);
        $encoded = json_encode($object);

        return " var languageObject=JSON.parse(`$encoded`); ";
    }

    public static function phpObject($path)
    {
        $allPath = self::$basePath.$path;
        $files = array_values(array_diff(scandir($allPath), array('.', '..')));
        $result = [];
        foreach ($files as $fileName) {
            $key = pathinfo($fileName, PATHINFO_FILENAME);
            $result[$key] = include "$allPath/$fileName";
        }

        return $result;
    }

    public static function jsFunction()
    {
        $text = '
            function __l(file,key){
                if(
                    typeof languageObject!="undefined"
                    &&
                    typeof languageObject[file]!="undefined"
                    &&
                    typeof languageObject[file][key]!="undefined"
                  )
                    return languageObject[file][key];
                  else
                    return key;  
            };
        ';

        return str_replace(array("\r", "\n", "  "), '', $text);
    }

}
