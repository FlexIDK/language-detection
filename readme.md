# PHP ngram language detection

PHP library that detects the language from a text string.

## Features

- More than 350 supported languages
- Very fast, no database needed
- Packaged with a 500kb dataset
- Learning steps are already done, library is ready to use
- Small code, small footprint
- N-grams algorithm
- Supports PHP 8.0

## Install

```bash
composer require one23/language-detection
```

---

## Quick usage



---

## Ngram

### What's this?

This package gets you bigrams, trigrams, all the [n-grams](https://en.wikipedia.org/wiki/N-gram)!

### Use

```php
use \One23\LanguageDetection\Ngram;

Ngram::biGram("hello");     // => ['he', 'el', 'll', 'lo'];
Ngram::nGram("hello", 2);   // => ['he', 'el', 'll', 'lo'];

Ngram::triBram("hello");    // => ['hel', 'ell', 'llo'];
Ngram::nGram("hello", 3);   // => ['hel', 'ell', 'llo'];

Ngram::nGram("hello", 4);   // => ['hell', 'ello'];
Ngram::nGram("hello", 5);   // => ['hello'];
Ngram::nGram("hello", 6);   // => [];
```

---

## Utils\Trigram

### Use

```php
use \One23\LanguageDetection\Utils\Trigram;

Trigram::clean(" hello@world ");        // => hello world
Trigram::trigrams(" hello@world ");     // => [" he","hel","ell","llo","lo ","o w"," wo","wor","orl","rld","ld "]
Trigram::asDictionary(" hello@hello "); // => {" he":2,"hel":2,"ell":2,"llo":2,"lo ":2,"o h":1}

$tuples = Trigram::asTuples(" world@world "); 
// => [["d w",1],[" wo",2],["wor",2],["orl",2],["rld",2],["ld ",2]]

Trigram::tuplesAsDictionary($tuples);   // => {"d w":1," wo":2,"wor":2,"orl":2,"rld":2,"ld ":2}

```

---

## Utils\WhitespaceCollapse

### Use

```php
use \One23\LanguageDetection\Utils\WhitespaceCollapse;

$str = " Hello\tworld!" .
    "\n" .
    "Hello  world!" .
    "\n" .
    "Hello \t world! " .
    "\n" .
    " \t " .
    "\n" .
    "\n" .
    " Hello \t world! " .
    "\n";

WhitespaceCollapse::collapse($str, []); // " Hello world! Hello world! Hello world! Hello world! "
WhitespaceCollapse::collapse($str, ['trim' => true, ]); // "Hello world! Hello world! Hello world! Hello world!"
WhitespaceCollapse::collapse($str, ['trim' => true, 'pattern' => 'html', ]); // "Hello world! Hello world! Hello world! Hello world!"

WhitespaceCollapse::collapse($str, ['trim' => true, 'pattern' => 'html', 'lineEnd' => true, ]);
/** =>
Hello world!
Hello world!
Hello
world!
Hello world!
**/
```

---

## License

[MIT](https://github.com/FlexIDK/language-detection/LICENSE)
