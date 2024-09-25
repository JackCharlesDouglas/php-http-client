<?php

namespace Http\Client;

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
}
