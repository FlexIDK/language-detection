<?php
declare(strict_types=1);

namespace One23\LanguageDetection\Utils;

class Value {

    public static function intLimit($val = null, int $default = null, int $min = null, int $max = null) : ?int
    {
        if (is_numeric($val)) {
            $val = (int)$val;
        }
        else {
            $val = null;
        }

        if (!is_null($val)) {
            if (!is_null($min) && $val < $min) {
                $val = null;
            }

            if (!is_null($max) && $val > $max) {
                $val = null;
            }
        }

        if (!is_null($default) && is_null($val)) {
            $val = $default;
        }

        return $val;
    }

}
