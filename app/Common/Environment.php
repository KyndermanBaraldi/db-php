<?php

namespace App\common;

/**
 * Undocumented class
 */
class Environment
{
    /**
     * method responsible for loading the .env file
     *
     * @param string $dir > absolute path
     * 
     * @return bool
     */
    public static function load(string $dir): bool
    {

        //checks if the .env file exists
        if (!file_exists($dir.'/.env')){
            return false;
        }

        //set the environment variables
        $lines = file($dir.'/.env');
        foreach ($lines as $line) {
            putenv(trim($line));
        }

        return true;
    }
}
