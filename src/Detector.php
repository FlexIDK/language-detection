<?php
declare(strict_types=1);

namespace One23\LanguageDetection;

use \One23\LanguageDetection\Utils\Value;
use \One23\LanguageDetection\Utils\WhitespaceCollapse;
use \One23\LanguageDetection\Utils\Trigram;

class Detector {

    /**
     * @var string[]
     */
    protected array $regexps = [
        // utf-16

        // jpn
        // |\x{D82C}[\x{DC01}-\x{DD1F}\x{DD50}-\x{DD52}]|\x{D83C}\x{DE00}|\x{D82B}[\x{DFF0}-\x{DFF3}\x{DFF5}-\x{DFFB}\x{DFFD}\x{DFFE}]|\x{D82C}[\x{DC00}\x{DD20}-\x{DD22}\x{DD64}-\x{DD67}]
        // Canadian_Aboriginal
        // |\x{D806}[\x{DEB0}-\x{DEBF}]
        // amh
        // |\x{D839}[\x{DFE0}-\x{DFE6}\x{DFE8}-\x{DFEB}\x{DFED}\x{DFEE}\x{DFF0}-\x{DFFE}]
        // sin
        // |\x{D804}[\x{DDE1}-\x{DDF4}]
        // tam
        // |\x{D807}[\x{DFC0}-\x{DFF1}\x{DFFF}]
        // ell
        // |\x{D800}[\x{DD40}-\x{DD8E}\x{DDA0}]|\x{D834}[\x{DE00}-\x{DE45}]
        // Ethiopic
        // |\x{D839}[\x{DFE0}-\x{DFE6}\x{DFE8}-\x{DFEB}\x{DFED}\x{DFEE}\x{DFF0}-\x{DFFE}]
        // Latin
        // |\x{D801}[\x{DF80}-\x{DF85}\x{DF87}-\x{DFB0}\x{DFB2}-\x{DFBA}]|\x{D837}[\x{DF00}-\x{DF1E}]
        // cmn
        // |\x{D81B}[\x{DFE2}\x{DFE3}\x{DFF0}\x{DFF1}]|[\x{D840}-\x{D868}\x{D86A}-\x{D86C}\x{D86F}-\x{D872}\x{D874}-\x{D879}\x{D880}-\x{D883}][\x{DC00}-\x{DFFF}]|\x{D869}[\x{DC00}-\x{DEDF}\x{DF00}-\x{DFFF}]|\x{D86D}[\x{DC00}-\x{DF38}\x{DF40}-\x{DFFF}]|\x{D86E}[\x{DC00}-\x{DC1D}\x{DC20}-\x{DFFF}]|\x{D873}[\x{DC00}-\x{DEA1}\x{DEB0}-\x{DFFF}]|\x{D87A}[\x{DC00}-\x{DFE0}]|\x{D87E}[\x{DC00}-\x{DE1D}]|\x{D884}[\x{DC00}-\x{DF4A}]
        // Arabic
        // |\x{D803}[\x{DE60}-\x{DE7E}]|\x{D83B}[\x{DE00}-\x{DE03}\x{DE05}-\x{DE1F}\x{DE21}\x{DE22}\x{DE24}\x{DE27}\x{DE29}-\x{DE32}\x{DE34}-\x{DE37}\x{DE39}\x{DE3B}\x{DE42}\x{DE47}\x{DE49}\x{DE4B}\x{DE4D}-\x{DE4F}\x{DE51}\x{DE52}\x{DE54}\x{DE57}\x{DE59}\x{DE5B}\x{DE5D}\x{DE5F}\x{DE61}\x{DE62}\x{DE64}\x{DE67}-\x{DE6A}\x{DE6C}-\x{DE72}\x{DE74}-\x{DE77}\x{DE79}-\x{DE7C}\x{DE7E}\x{DE80}-\x{DE89}\x{DE8B}-\x{DE9B}\x{DEA1}-\x{DEA3}\x{DEA5}-\x{DEA9}\x{DEAB}-\x{DEBB}\x{DEF0}\x{DEF1}]

        //
        //
        //

        'cmn' => '/[\x{2E80}-\x{2E99}\x{2E9B}-\x{2EF3}\x{2F00}-\x{2FD5}\x{3005}\x{3007}\x{3021}-\x{3029}\x{3038}-\x{303B}\x{3400}-\x{4DBF}\x{4E00}-\x{9FFF}\x{F900}-\x{FA6D}\x{FA70}-\x{FAD9}]/u',
        'Latin' => '/[A-Za-z\x{00AA}\x{00BA}\x{00C0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{02B8}\x{02E0}-\x{02E4}\x{1D00}-\x{1D25}\x{1D2C}-\x{1D5C}\x{1D62}-\x{1D65}\x{1D6B}-\x{1D77}\x{1D79}-\x{1DBE}\x{1E00}-\x{1EFF}\x{2071}\x{207F}\x{2090}-\x{209C}\x{212A}\x{212B}\x{2132}\x{214E}\x{2160}-\x{2188}\x{2C60}-\x{2C7F}\x{A722}-\x{A787}\x{A78B}-\x{A7CA}\x{A7D0}\x{A7D1}\x{A7D3}\x{A7D5}-\x{A7D9}\x{A7F2}-\x{A7FF}\x{AB30}-\x{AB5A}\x{AB5C}-\x{AB64}\x{AB66}-\x{AB69}\x{FB00}-\x{FB06}\x{FF21}-\x{FF3A}\x{FF41}-\x{FF5A}]/u',
        'Cyrillic' => '/[\x{0400}-\x{0484}\x{0487}-\x{052F}\x{1C80}-\x{1C88}\x{1D2B}\x{1D78}\x{2DE0}-\x{2DFF}\x{A640}-\x{A69F}\x{FE2E}\x{FE2F}]/u',
        'Arabic' => '/[\x{0600}-\x{0604}\x{0606}-\x{060B}\x{060D}-\x{061A}\x{061C}-\x{061E}\x{0620}-\x{063F}\x{0641}-\x{064A}\x{0656}-\x{066F}\x{0671}-\x{06DC}\x{06DE}-\x{06FF}\x{0750}-\x{077F}\x{0870}-\x{088E}\x{0890}\x{0891}\x{0898}-\x{08E1}\x{08E3}-\x{08FF}\x{FB50}-\x{FBC2}\x{FBD3}-\x{FD3D}\x{FD40}-\x{FD8F}\x{FD92}-\x{FDC7}\x{FDCF}\x{FDF0}-\x{FDFF}\x{FE70}-\x{FE74}\x{FE76}-\x{FEFC}]/u',
        'ben' => '/[\x{0980}-\x{0983}\x{0985}-\x{098C}\x{098F}\x{0990}\x{0993}-\x{09A8}\x{09AA}-\x{09B0}\x{09B2}\x{09B6}-\x{09B9}\x{09BC}-\x{09C4}\x{09C7}\x{09C8}\x{09CB}-\x{09CE}\x{09D7}\x{09DC}\x{09DD}\x{09DF}-\x{09E3}\x{09E6}-\x{09FE}]/u',
        'Devanagari' => '/[\x{0900}-\x{0950}\x{0955}-\x{0963}\x{0966}-\x{097F}\x{A8E0}-\x{A8FF}]/u',
        'jpn' => '/[\x{3041}-\x{3096}\x{309D}-\x{309F}]|[\x{30A1}-\x{30FA}\x{30FD}-\x{30FF}\x{31F0}-\x{31FF}\x{32D0}-\x{32FE}\x{3300}-\x{3357}\x{FF66}-\x{FF6F}\x{FF71}-\x{FF9D}]|[㐀-䶵一-龯]/u',
        'jav' => '/[\x{A980}-\x{A9CD}\x{A9D0}-\x{A9D9}\x{A9DE}\x{A9DF}]/u',
        'kor' => '/[\x{1100}-\x{11FF}\x{302E}\x{302F}\x{3131}-\x{318E}\x{3200}-\x{321E}\x{3260}-\x{327E}\x{A960}-\x{A97C}\x{AC00}-\x{D7A3}\x{D7B0}-\x{D7C6}\x{D7CB}-\x{D7FB}\x{FFA0}-\x{FFBE}\x{FFC2}-\x{FFC7}\x{FFCA}-\x{FFCF}\x{FFD2}-\x{FFD7}\x{FFDA}-\x{FFDC}]/u',
        'tel' => '/[\x{0C00}-\x{0C0C}\x{0C0E}-\x{0C10}\x{0C12}-\x{0C28}\x{0C2A}-\x{0C39}\x{0C3C}-\x{0C44}\x{0C46}-\x{0C48}\x{0C4A}-\x{0C4D}\x{0C55}\x{0C56}\x{0C58}-\x{0C5A}\x{0C5D}\x{0C60}-\x{0C63}\x{0C66}-\x{0C6F}\x{0C77}-\x{0C7F}]/u',
        'tam' => '/[\x{0B82}\x{0B83}\x{0B85}-\x{0B8A}\x{0B8E}-\x{0B90}\x{0B92}-\x{0B95}\x{0B99}\x{0B9A}\x{0B9C}\x{0B9E}\x{0B9F}\x{0BA3}\x{0BA4}\x{0BA8}-\x{0BAA}\x{0BAE}-\x{0BB9}\x{0BBE}-\x{0BC2}\x{0BC6}-\x{0BC8}\x{0BCA}-\x{0BCD}\x{0BD0}\x{0BD7}\x{0BE6}-\x{0BFA}]/u',
        'guj' => '/[\x{0A81}-\x{0A83}\x{0A85}-\x{0A8D}\x{0A8F}-\x{0A91}\x{0A93}-\x{0AA8}\x{0AAA}-\x{0AB0}\x{0AB2}\x{0AB3}\x{0AB5}-\x{0AB9}\x{0ABC}-\x{0AC5}\x{0AC7}-\x{0AC9}\x{0ACB}-\x{0ACD}\x{0AD0}\x{0AE0}-\x{0AE3}\x{0AE6}-\x{0AF1}\x{0AF9}-\x{0AFF}]/u',
        'kan' => '/[\x{0C80}-\x{0C8C}\x{0C8E}-\x{0C90}\x{0C92}-\x{0CA8}\x{0CAA}-\x{0CB3}\x{0CB5}-\x{0CB9}\x{0CBC}-\x{0CC4}\x{0CC6}-\x{0CC8}\x{0CCA}-\x{0CCD}\x{0CD5}\x{0CD6}\x{0CDD}\x{0CDE}\x{0CE0}-\x{0CE3}\x{0CE6}-\x{0CEF}\x{0CF1}\x{0CF2}]/u',
        'mal' => '/[\x{0D00}-\x{0D0C}\x{0D0E}-\x{0D10}\x{0D12}-\x{0D44}\x{0D46}-\x{0D48}\x{0D4A}-\x{0D4F}\x{0D54}-\x{0D63}\x{0D66}-\x{0D7F}]/u',
        'Myanmar' => '/[\x{1000}-\x{109F}\x{A9E0}-\x{A9FE}\x{AA60}-\x{AA7F}]/u',
        'pan' => '/[\x{0A01}-\x{0A03}\x{0A05}-\x{0A0A}\x{0A0F}\x{0A10}\x{0A13}-\x{0A28}\x{0A2A}-\x{0A30}\x{0A32}\x{0A33}\x{0A35}\x{0A36}\x{0A38}\x{0A39}\x{0A3C}\x{0A3E}-\x{0A42}\x{0A47}\x{0A48}\x{0A4B}-\x{0A4D}\x{0A51}\x{0A59}-\x{0A5C}\x{0A5E}\x{0A66}-\x{0A76}]/u',
        'Ethiopic' => '/[\x{1200}-\x{1248}\x{124A}-\x{124D}\x{1250}-\x{1256}\x{1258}\x{125A}-\x{125D}\x{1260}-\x{1288}\x{128A}-\x{128D}\x{1290}-\x{12B0}\x{12B2}-\x{12B5}\x{12B8}-\x{12BE}\x{12C0}\x{12C2}-\x{12C5}\x{12C8}-\x{12D6}\x{12D8}-\x{1310}\x{1312}-\x{1315}\x{1318}-\x{135A}\x{135D}-\x{137C}\x{1380}-\x{1399}\x{2D80}-\x{2D96}\x{2DA0}-\x{2DA6}\x{2DA8}-\x{2DAE}\x{2DB0}-\x{2DB6}\x{2DB8}-\x{2DBE}\x{2DC0}-\x{2DC6}\x{2DC8}-\x{2DCE}\x{2DD0}-\x{2DD6}\x{2DD8}-\x{2DDE}\x{AB01}-\x{AB06}\x{AB09}-\x{AB0E}\x{AB11}-\x{AB16}\x{AB20}-\x{AB26}\x{AB28}-\x{AB2E}]/u',
        'tha' => '/[\x{0E01}-\x{0E3A}\x{0E40}-\x{0E5B}]/u',
        'sin' => '/[\x{0D81}-\x{0D83}\x{0D85}-\x{0D96}\x{0D9A}-\x{0DB1}\x{0DB3}-\x{0DBB}\x{0DBD}\x{0DC0}-\x{0DC6}\x{0DCA}\x{0DCF}-\x{0DD4}\x{0DD6}\x{0DD8}-\x{0DDF}\x{0DE6}-\x{0DEF}\x{0DF2}-\x{0DF4}]/u',
        'ell' => '/[\x{0370}-\x{0373}\x{0375}-\x{0377}\x{037A}-\x{037D}\x{037F}\x{0384}\x{0386}\x{0388}-\x{038A}\x{038C}\x{038E}-\x{03A1}\x{03A3}-\x{03E1}\x{03F0}-\x{03FF}\x{1D26}-\x{1D2A}\x{1D5D}-\x{1D61}\x{1D66}-\x{1D6A}\x{1DBF}\x{1F00}-\x{1F15}\x{1F18}-\x{1F1D}\x{1F20}-\x{1F45}\x{1F48}-\x{1F4D}\x{1F50}-\x{1F57}\x{1F59}\x{1F5B}\x{1F5D}\x{1F5F}-\x{1F7D}\x{1F80}-\x{1FB4}\x{1FB6}-\x{1FC4}\x{1FC6}-\x{1FD3}\x{1FD6}-\x{1FDB}\x{1FDD}-\x{1FEF}\x{1FF2}-\x{1FF4}\x{1FF6}-\x{1FFE}\x{2126}\x{AB65}]/u',
        'khm' =>  '/[\x{1780}-\x{17DD}\x{17E0}-\x{17E9}\x{17F0}-\x{17F9}\x{19E0}-\x{19FF}]/u',
        'hye' =>  '/[\x{0531}-\x{0556}\x{0559}-\x{058A}\x{058D}-\x{058F}\x{FB13}-\x{FB17}]/u',
        'sat' =>  '/[\x{1C50}-\x{1C7F}]/u',
        'Tibtan' => '/[\x{0F00}-\x{0F47}\x{0F49}-\x{0F6C}\x{0F71}-\x{0F97}\x{0F99}-\x{0FBC}\x{0FBE}-\x{0FCC}\x{0FCE}-\x{0FD4}\x{0FD9}\x{0FDA}]/u',
        'Hebrew' => '/[\x{0591}-\x{05C7}\x{05D0}-\x{05EA}\x{05EF}-\x{05F4}\x{FB1D}-\x{FB36}\x{FB38}-\x{FB3C}\x{FB3E}\x{FB40}\x{FB41}\x{FB43}\x{FB44}\x{FB46}-\x{FB4F}]/u',
        'kat' =>  '/[\x{10A0}-\x{10C5}\x{10C7}\x{10CD}\x{10D0}-\x{10FA}\x{10FC}-\x{10FF}\x{1C90}-\x{1CBA}\x{1CBD}-\x{1CBF}\x{2D00}-\x{2D25}\x{2D27}\x{2D2D}]/u',
        'lao' =>  '/[\x{0E81}\x{0E82}\x{0E84}\x{0E86}-\x{0E8A}\x{0E8C}-\x{0EA3}\x{0EA5}\x{0EA7}-\x{0EBD}\x{0EC0}-\x{0EC4}\x{0EC6}\x{0EC8}-\x{0ECD}\x{0ED0}-\x{0ED9}\x{0EDC}-\x{0EDF}]/u',
        'zgh' =>  '/[\x{2D30}-\x{2D67}\x{2D6F}\x{2D70}\x{2D7F}]/u',
        'iii' =>  '/[\x{A000}-\x{A48C}\x{A490}-\x{A4C6}]/u',
        'aii' =>  '/[\x{0700}-\x{070D}\x{070F}-\x{074A}\x{074D}-\x{074F}\x{0860}-\x{086A}]/u',
        'div' =>  '/[\x{0780}-\x{07B1}]/u',
        'vai' =>  '/[\x{A500}-\x{A62B}]/u',
        'Canadian_Aboriginal' => '/[\x{1400}-\x{167F}\x{18B0}-\x{18F5}]/u',
        'chr' =>  '/[\x{13A0}-\x{13F5}\x{13F8}-\x{13FD}\x{AB70}-\x{ABBF}]/u',
        'kkh' =>  '/[\x{1A20}-\x{1A5E}\x{1A60}-\x{1A7C}\x{1A7F}-\x{1A89}\x{1A90}-\x{1A99}\x{1AA0}-\x{1AAD}]/u',
        'blt' =>  '/[\x{AA80}-\x{AAC2}\x{AADB}-\x{AADF}]/u',
        'mya' => '/[\x{1000}-\x{109F}\x{A9E0}-\x{A9FE}\x{AA60}-\x{AA7F}]/u',
        'amh' => '/[\x{1200}-\x{1248}\x{124A}-\x{124D}\x{1250}-\x{1256}\x{1258}\x{125A}-\x{125D}\x{1260}-\x{1288}\x{128A}-\x{128D}\x{1290}-\x{12B0}\x{12B2}-\x{12B5}\x{12B8}-\x{12BE}\x{12C0}\x{12C2}-\x{12C5}\x{12C8}-\x{12D6}\x{12D8}-\x{1310}\x{1312}-\x{1315}\x{1318}-\x{135A}\x{135D}-\x{137C}\x{1380}-\x{1399}\x{2D80}-\x{2D96}\x{2DA0}-\x{2DA6}\x{2DA8}-\x{2DAE}\x{2DB0}-\x{2DB6}\x{2DB8}-\x{2DBE}\x{2DC0}-\x{2DC6}\x{2DC8}-\x{2DCE}\x{2DD0}-\x{2DD6}\x{2DD8}-\x{2DDE}\x{AB01}-\x{AB06}\x{AB09}-\x{AB0E}\x{AB11}-\x{AB16}\x{AB20}-\x{AB26}\x{AB28}-\x{AB2E}]/u',
        'bod' => '/[\x{0F00}-\x{0F47}\x{0F49}-\x{0F6C}\x{0F71}-\x{0F97}\x{0F99}-\x{0FBC}\x{0FBE}-\x{0FCC}\x{0FCE}-\x{0FD4}\x{0FD9}\x{0FDA}]/u',
    ];

    const DEFAULT_MIN_LENGTH = 16;
    const DEFAULT_MAX_LENGTH = 2048;
    const DEFAULT_MIN_DIFFERENCE = 256;
    const DEFAULT_MAX_DIFFERENCE = 300;

    protected array $options = [
        'minLength'     => self::DEFAULT_MIN_LENGTH,
        'maxLength'     => self::DEFAULT_MAX_LENGTH,
        'maxDifference' => self::DEFAULT_MAX_DIFFERENCE,

        'only'      => null,
        'dict'      => 'default',
    ];

    protected ?array $dictionary= null;
    protected ?array $trigram   = null;
    protected ?array $result    = null;
    protected ?string $str      = null;

    public function __construct(array $options = [])
    {
        if (isset($options['dict'])) {
            $this->setDictionary($options['dict']);
        }

        if (isset($options['only'])) {
            $this->setOnly($options['only']);
        }

        if (isset($options['minLength'])) {
            $options['minLength'] = Value::intLimit($options['minLength'], self::DEFAULT_MIN_LENGTH, 1);
        }

        if (isset($options['maxLength'])) {
            $options['maxLength'] = Value::intLimit($options['maxLength'], self::DEFAULT_MAX_LENGTH, $options['minLength']);
        }

        if (isset($options['maxDifference'])) {
            $options['maxDifference'] = Value::intLimit($options['maxDifference'], self::DEFAULT_MAX_DIFFERENCE, self::DEFAULT_MIN_DIFFERENCE);
        }

        $this->options = [
            ...$this->options,
            $options
        ];
    }

    /**
     * Set limit dictionary for even better performance
     *
     * @param string $dict
     * @return $this
     * @throws Exception
     */
    public function setDictionary(string $dict): self {
        $this->dictionary   = null;
        $this->trigram      = null;
        $this->result       = null;

        if (!in_array($dict, ['all', 'min', 'default'])) {
            throw new Exception("Dictionary can only: 'all', 'min' or 'default'");
        }

        $this->options['dict'] = $dict;

        return $this;
    }

    /**
     * Set limit loaded languages for even better performance
     *
     * @param string[] $lang
     * @return $this
     */
    public function setOnly(array $lang = null): self {
        $this->result = null;

        if (!count($lang)) {
            $this->options['only'] = null;

            return $this;
        }

        $only = array_map(function($val) {
            return (string)$val ?: null;
        }, $lang);

        $only = array_unique(array_filter($only));

        $this->options['only'] = $only;

        return $this;
    }

    /**
     * Get limited languages by supported languages
     *
     * @return string[]
     */
    public function getOnly(): ?array {
        $only = $this->options['only'];
        if (
            is_null($only) ||
            (
                is_array($only) &&
                !count($only)
            )
        ) {
            return null;
        }

        $available = $this->getSupportedLanguages();
        $intersect = array_intersect($available, $only ?: []);

        return count($intersect)
            ? array_values($intersect)
            : null;
    }

    /**
     * It performs an evaluation on a given text.
     *
     * @param string $str
     * @return $this
     */
    public function evaluate(string $str): self {
        $this->result = null;

        $this->str = $str;

        return $this;
    }

    /**
     * Returns the last string which has been evaluated
     *
     * @return string
     * @throws Exception
     */
    public function getText(): string {
        if (is_null($this->str)) {
            throw new Exception("Text string undefined");
        }

        return $this->str;
    }

    /**
     * The detected language
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getLanguage() ?: "";
    }

    /**
     * The detected language
     *
     * @return string|null
     */
    public function getLanguage(): ?string {
        return $this->getLanguages()[0] ?? null;
    }

    /**
     * A list of loaded models that will be evaluated.
     *
     * @return string[]
     */
    public function getLanguages(): array {
        $scores = $this->getScores();

        return array_map(function($val) {
            /** @var array{string, float} $val */
            return $val[0];
        }, $scores);
    }

    /**
     * A list of scores by language, for all evaluated languages.
     *
     * @return float[]
     */
    public function getScores(): array {
        if (!is_null($this->result)) {
            return $this->result;
        }

        //

        $this->getDictionary();

        //

        $str = \mb_substr(
            WhitespaceCollapse::collapse(
                $this->getText(),
                [
                    'pattern'   => 'html',
                    'trim'      => true,
                ]
            ),
            0,
            $this->options['maxLength']
        );

        $length = \mb_strlen($str);
        if ($length < $this->options['minLength']) {
            return $this->undefinedTuples();
        }

        list($lang, $score, $regexp) = $this->getTopRegexp($str);

        $only = $this->getOnly();
        if (!$lang || !isset($this->trigram[$lang])) {
            if (
                !$lang ||
                $score === 0
            ) {
                return $this->undefinedTuples();
//                throw new Exception("Can't detect alphabet, language");
            }

            if (
                $only &&
                !in_array($lang, $only)
            ) {
                return $this->undefinedTuples();
//                throw new Exception("Detect: '{$lang}'. Current 'language' limit by 'only'");
            }

            return $this->singleLanguageTuples($lang);
        }

        return $this->normalize(
            $str,
            $this->getDistances(
                Trigram::asTuples($str),
                $this->trigram[$lang]
            )
        );
    }

    /**
     * Get the distance between an array of trigram—count
     *
     * @param array $trigrams
     * @param array $languages
     * @return array[]
     */
    protected function getDistances(array $trigrams, array $languages): array {
        $only = array_intersect(
            $this->getOnly() ?: $this->getSupportedLanguages(),
            array_keys($languages),
        );

        $distances = [];
        foreach ($only as $lang) {
            $distances[] = [
                $lang,
                $this->getDistance($trigrams, $languages[$lang])
            ];
        }

        if (count($distances)) {
            usort($distances, function($a, $b) {
                return $a[1] - $b[1];
            });

            return $distances;
        }
        else {
            return $this->undefinedTuples();
        }
    }

    protected function getDistance(array $trigrams, array $model) {
        $distance = 0;
        $index = -1;

        $cnt = count($trigrams);
        while (++$index < $cnt) {
            $trigram = $trigrams[$index];
            $difference = $this->options['maxDifference'];

            if (isset($model[$trigram[0]])) {
                $difference = $trigram[1] - $model[$trigram[0]] - 1;

                if ($difference < 0) {
                    $difference = -$difference;
                }
            }

            $distance += $difference;
        }

        return $distance;
    }

    /**
     * Create 'undefined' tuple as a list of tuples
     *
     * @return array[]
     */
    protected function undefinedTuples(): array {
        return $this->singleLanguageTuples('und');
    }

    /**
     * Create a single tuple as a list of tuples from a given language code.
     *
     * @param string $lang
     * @return array[]
     */
    protected function singleLanguageTuples(string $lang): array {
        return [[$lang, 1]];
    }

    /**
     * Construct trigram dictionaries
     *
     * @return array
     */
    protected function trigramDictionary(): array {
        $data = [];

        $dict = $this->getDictionary();

        foreach ($dict as $alphabet => $languages) {
            $data[$alphabet] = [];

            foreach ($languages as $lang => $ngrams) {
                $model = explode('|', $ngrams);

                $trigrams   = [];
                $weight     = count($model);

                while ($weight--) {
                    $trigrams[$model[$weight]] = $weight;
                }

                $data[$alphabet][$lang] = $trigrams;
            }
        }

        return $data;
    }

    /**
     * Get the most occurring expression
     *
     * @param string $str
     * @return array{?string, float, ?string}
     */
    protected function getTopRegexp(string $str): array {
        $topScore   = -1;
        $topRegexp  = null;
        $topLang     = null;

        foreach ($this->regexps as $key => $regexp) {
            $cnt = $this->getOccurrence($str, $regexp);

            if ($cnt > $topScore) {
                $topScore   = $cnt;
                $topRegexp  = $regexp;
                $topLang    = $key;
            }
        }

        return [$topLang, $topScore, $topRegexp];
    }

    /**
     * Normalize the difference for each tuple
     *
     * @param string $str
     * @param array $distances
     * @return array
     */
    protected function normalize(string $str, array $distances): array {
        $length = \mb_strlen($str);

        $min = $distances[0][1];
        $max = $length * $this->options['maxDifference'] - $min;

        $index = -1;
        $cnt = count($distances);

        while (++$index < $cnt) {
            $distances[$index][1] = (1 - ($distances[$index][1] - $min) / $max) ?: 0;
        }

        return $distances;
    }

    protected function getOccurrence(string $str, string $regexp): float {
        if (preg_match_all($regexp, $str, $m)) {
            $length = \mb_strlen($str);
            if (!$length) {
                return 0;
            }

            $cnt = count($m[0] ?? []);

            return ($cnt ?: 0) / $length;
        }

        return 0;
    }

    /**
     * Get dictionary from memory or disk
     *
     * @return array
     * @throws Exception
     */
    protected function getDictionary(): array {
        if (!is_null($this->dictionary)) {
            return $this->dictionary;
        }

        $path = realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR ."resources" . DIRECTORY_SEPARATOR . "{$this->options['dict']}.php");
        if (!$path) {
            throw new Exception("Dictionary '{$this->options['dict']}' not found");
        }

        $this->dictionary   = include($path);
        $this->trigram      = $this->trigramDictionary();

        return $this->dictionary;
    }

    /**
     * A list of supported languages that will be evaluated.
     *
     * @return string[]
     */
    public function getSupportedLanguages(): array {
        $dictionary = $this->getDictionary();

        $result = [];
        foreach ($dictionary as $group => $languages) {
            $result = [
                ...$result,
                ...array_keys($languages)
            ];
        }

        sort($result);

        return $result;
    }

    /**
     * With a static call on detect() method, you can perform an evaluation on a given text, in one line.
     *
     * @param string $str
     * @param array $options
     * @return static
     * @throws Exception
     */
    public static function detect(string $str, array $options = []): self {
        return (new self($options))
            ->evaluate($str);
    }

}
