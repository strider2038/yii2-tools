<?php

namespace strider2038\tools\helpers;

/**
 * Formatting helper
 *
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class Format {
    /**
     * Formatting bytes
     * @see http://stackoverflow.com/questions/2510434/format-bytes-to-kilobytes-megabytes-gigabytes
     * @param integer $bytes
     * @param integer $precision
     * @return string
     */
    static public function bytes($bytes, $precision = 2) { 
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 
}
