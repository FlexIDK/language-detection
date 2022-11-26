<?php
declare(strict_types=1);

namespace One23\LanguageDetection;

use \One23\Iso639\Code1 as Code1;
use \One23\Iso639\Code2t as Code2t;
use \One23\Iso639\Code2b as Code2b;
use One23\Iso639\Code3Min;
use \One23\Iso639\Code3Min as Code3;
use \One23\Iso639\Exception as Iso639Exception;

class Detector639 extends Detector {

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        if (!isset($options['only'])) {
            $this->setOnly([]);
        }
    }

    public function getSupportedLanguages(): array {
        $support = parent::getSupportedLanguages();
        $code3 = Code3::all();

        return array_values(
            array_intersect($code3, $support)
        );
    }

    public function setOnly(array $lang = null): self {
        $this->result = null;

        //

        $intersect = self::getSupportedLanguages();
        if (!count($lang)) {
            return parent::setOnly($intersect);
        }

        $only = array_map(function($val) {
            return (string)$val ?: null;
        }, $lang);

        $intersect1 = array_intersect($only, $intersect);

        if (!count($intersect1)) {
            return parent::setOnly($intersect);
        }

        return parent::setOnly($intersect1);
    }

    //

    /**
     * @return array{string, float, Code3Min}
     */
    public function getScores(): array
    {
        $result = parent::getScores();

        foreach ($result as &$item) {
            $item[2] = Code3::from($item[0]);
        }

        return $result;
    }

    public function getLanguages(): array
    {
        $scores = $this->getScores();

        return array_map(function($val) {
            /** @var array{string, float, Code3Min} $val */
            return $val[2];
        }, $scores);
    }

    public function getLanguage(): ?string
    {
        return (string)$this->getLanguages()[0] ?? null;
    }

    //

    public function code1(): ?Code1 {
        return $this->code3()
            ?->code1();
    }

    public function code2t(): ?Code2t {
        return $this->code3()
            ?->code2t();
    }

    public function code2b(): ?Code2b {
        return $this->code3()
            ?->code2b();
    }

    public function code3(): ?Code3 {
        try {
            return $this->getLanguages()[0] ?? null;
        }
        catch (Iso639Exception $exception) {}

        return null;
    }

}
