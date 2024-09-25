<?php

namespace Http\Client;

use Exception;

/**
 * Utility functions
 * 
 * @package Http\Client
 * 
 * @author Jack Douglas
 */
trait Utils
{
    /**
     * Checks if the given array is an associative array.
     *
     * @param array $array The input array
     *
     * @return bool True if the array is associative, false otherwise
     */
    public static function isAssocArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Validates whether the given string is a valid JSON or not.
     * 
     * The logic used here is very simple, it only checks if the first character
     * of the string is one of the valid start characters for a JSON string.
     * 
     * @param string $json The string to validate
     * 
     * @return bool True if the string is a valid JSON, false otherwise
     */
    public static function validateJson(string $json): bool
    {
        if ($json === '') {
            return false;
        }

        $validStartChars = ['{', '[', '"', '-', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 't', 'f', 'n'];
        $json = trim($json);
        return in_array($json[0], $validStartChars);
    }
}
