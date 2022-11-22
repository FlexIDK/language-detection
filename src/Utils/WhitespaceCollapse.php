<?php
declare(strict_types=1);

namespace One23\LanguageDetection\Utils;

class WhitespaceCollapse {
    protected array $pattern = [
        'js'    => '/\s+/u',
        'html'  => '/[\t\n\v\f\r ]+/u',
    ];

    protected array $options = [
        'pattern'   => 'js',
        'trim'      => false,
        'lineEnd'   => false,
    ];

    /**
     * @param string $str
     * @param array{pattern: string, trim: boolean, lineEnd: boolean} $options
     */
    public function __construct(public string $str, array $options = [])
    {
        $this->options = [
            ...$this->options,
            ...$options
        ];
    }

    protected function replaceLineEnd(string $str): string {
        preg_match("/\r?\n|\r/u", $str, $m);

        return $m[0] ?? " ";
    }

    public function toString(): string
    {
        $str = $this->str;

        $regexp = match ($this->options['pattern']) {
            'html'  => $this->pattern['html'],
            'js'    => $this->pattern['js'],
            default => $this->options['pattern'],
        };

        if (!!$this->options['lineEnd']) {
            $str = preg_replace_callback(
                $regexp,
                function($val) {
                    return $this->replaceLineEnd($val[0] ?: " ");
                },
                $str
            );
        }
        else {
            $str = preg_replace(
                $regexp,
                " ",
                $str
            );
        }

        if (!!$this->options['trim']) {
            $str = trim($str);
        }

        return $str;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function collapse(string $str, array $options = []): string
    {
        return (new self($str, $options))
            ->toString();
    }
}
