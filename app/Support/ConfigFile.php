<?php

namespace App\Support;


class ConfigFile
{
    
    public static function getPropertyFromEnv(string $propertyName, string $configFile): string {
        $myfile = fopen($configFile, "r") or die("Unable to open file!");
        while(!feof($myfile)) {
            $str = fgets($myfile);
            if (strpos($str, $propertyName) !== false) {
                $passportClientSecret = trim(explode("=", $str)[1]);
                $res =  $passportClientSecret;
                break;
            }
        }
        fclose($myfile);
        return $res;
    }
    
    public static function writePropertyToEnv(string $propertyName, string $newProperty, string $configFile) {
        $str = file_get_contents($configFile);
        $propertyValue = self::getPropertyFromEnv($propertyName, $configFile);
        $str=str_replace($propertyValue, $newProperty, $str);
        file_put_contents($configFile, $str);
    }

}





