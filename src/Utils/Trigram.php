<?php
declare(strict_types=1);

namespace One23\LanguageDetection\Utils;

use \One23\LanguageDetection\Ngram;

class Trigram {

    protected function __construct(public string $str)
    {
    }

    /**
     * Get clean trigrams as a dictionary
     *
     * @param string $str
     * @return array
     * @throws \One23\LanguageDetection\Exception
     */
    public static function asDictionary(string $str): array {
        $values = self::trigrams($str);

        $dictionary = [];
        $index = -1;
        $length = count($values);

        while (++$index < $length) {
            $key = $values[$index];

            if (isset($dictionary[$key])) {
                $dictionary[$key]++;
            }
            else {
                $dictionary[$key] = 1;
            }
        }

        return $dictionary;
    }

    /**
     * Get clean trigrams with occurrence counts as a tuple
     *
     * @param string $str
     * @return array{string, integer}
     */
    public static function asTuples(string $str): array {
        $dictionary = self::asDictionary($str);

        asort($dictionary);

        $tuples = [];
        foreach ($dictionary as $trigram => $val) {
            $tuples[] = [
                $trigram,
                $val
            ];
        }

        return $tuples;
    }

    /**
     * Tuples into a dictionary
     *
     * @param array $tuples
     * @return array
     */
    public static function tuplesAsDictionary(array $tuples): array {
        $dictionary = [];
        $index = -1;
        $length = count($tuples);

        while (++$index < $length) {
            $val = $tuples[$index];

            $dictionary[$val[0]] = $val[1];
        }

        return $dictionary;
    }

    /**
     * Useless punctuation, symbols, and numbers. Collapses white space, trims, and lowercases.
     *
     * @param string $str
     * @return string
     */
    public static function clean(string $str): string {
//        $str = preg_replace("/[\x{21}-\x{2F}\x{3A}-\x{40}\x{5B}\x{5D}-\x{60}\x{7B}-\x{7E}]+/u", " ", $str);
        $str = preg_replace("/[\W\t\s\x{21}-\x{40}\x{5B}\x{5D}-\x{60}\x{7B}-\x{7E}]+/u", " ", $str);

        return \mb_strtolower(
            trim($str),
            'UTF-8'
        );
    }

    /**
     * Make clean, padded trigrams
     *
     * @param string $str
     * @return string[]
     * @throws \One23\LanguageDetection\Exception
     */
    public static function trigrams(string $str): array {
        return Ngram::triGram(
            " " . self::clean($str) . " "
        );
    }

}
