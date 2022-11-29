<?php
declare(strict_types=1);

namespace One23\LanguageDetection;

class Ngram {

    /**
     * @param int $n
     * @throws Exception
     */
    protected function __construct(public int $n)
    {
        if ($n < 1) {
            throw new Exception("'{$n}' is not a valid argument");
        }
    }

    /**
     * @param string $str
     * @return array
     */
    protected function grams(string $str): array {
        $nGrams = [];

        $length = \mb_strlen($str, 'UTF-8') - $this->n + 1;

        if ($length < 1) {
            return $nGrams;
        }

        for($index = 0; $index < $length; $index++) {
            $nGrams[] = \mb_substr($str, $index, $this->n, 'UTF-8');
        }

        return $nGrams;
    }

    /**
     * @param string $str
     * @param int $n
     * @return string[]
     * @throws Exception
     */
    public static function nGram(string $str, int $n): array {
        return (new self($n))
            ->grams($str);
    }

    /**
     * @param string $str
     * @return string[]
     * @throws Exception
     */
    public static function biGram(string $str): array {
        return (new self(2))
            ->grams($str);
    }

    /**
     * @param string $str
     * @return string[]
     * @throws Exception
     */
    public static function triGram(string $str): array {
        return (new self(3))
            ->grams($str);
    }

}
