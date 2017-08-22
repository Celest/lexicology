[![Build Status](https://travis-ci.org/Celest/lexicology.svg?branch=master)](https://travis-ci.org/Celest/lexicology)

# Lexicology

PHP lexicology library.

- Suggests values from an array based on a lexical comparison
- Return sorted array based on lexical comparison
- Pick best match from an array
- Pick best match associations between arrays

## Core Lexical Comparisons

- [levenshtein](http://php.net/manual/en/function.levenshtein.php) using `LevenshteinDistance`
- [preg_grep](http://php.net/manual/en/function.preg_grep.php) using `PregGrep`
- [similar_text](http://php.net/manual/en/function.similar_text.php) using `Similarity`
- [soundex](http://php.net/manual/en/function.sounded.php) using `Soundex`

Also allows custom lexical comparison by extending `Lexicology\Method\AbstractMethod` and implementing `Lexicology\Method\MethodInterface`. See [Custom Method](#custom-method)

## Install

Composer
```bash
composer require celestial\lexicology
```

or composer.json
```json
{
   "require": {
       "celestial/lexicology": "^0.1"
   }
}

```


## Use

### Suggestion
The `Suggestion` class will suggest an array or value that match closely to a needle.
The default method is [PregGrep](#PregGrep) but that can be changed to one of the other methods or a custom method.
```php
<?php

  use Celestial\Lexicology\Suggestion;
  
  $suggestionOptions = [
    'string',  
    'new string',  
    'value',  
    'variable'  
  ];
  
  $suggestion = new Suggestion();
  $suggestions = $suggestion->getSuggestions('string', $suggestionOptions);
  
  print_r($suggestions);
  
//Array
//(
//    [0] => string
//    [1] => new string
//)
```

Attempting to get a single 'best' suggestion value will return a string or throw an exception. If you need to suppress the exception and return a non-standard or shared value (such as a meta field or constant) use the fourth parameter to override the result.
```php

<?php

  use Celestial\Lexicology\Suggestion;
  
  $suggestionOptions = [
    'string',  
    'new string',  
    'value',  
    'variable'  
  ];
  
  $suggestion = new Suggestion();
  $suggestions = $suggestion->getSingleSuggestion('string', $suggestionOptions);
  
  print_r($suggestions);
``` 

### Custom Method
A custom Method definition must implement either a `FilterInterface` or `RateInterface`

```php
<?php
  use Celestial\Lexicology\Method\AbstractMethod;
  use Celestial\Lexicology\Method\Interfaces\FilterInterface;
  use Celestial\Lexicology\Method\Interfaces\SortInterface;
  
  class CustomMethod extends AbstractMethod implements SortInterface, FilterInterface
  {
      use \Celestial\Lexicology\Method\Traits\SortTrait;
      
      /**
       * Return a sort value if either a or b match.
       * 
       * @inheritdoc 
       */
      public function sortPair($a, $b) {
        if ($a === $b) {
            return 0;
        } elseif ($a === $this->getField()) {
            return 1;
        } elseif ($b === $this->getField()) {
            return -1;
        }
        return null;
      }
      
      /**
       * Return a filter array of string that have more than 5 characters
       * 
       * @inheritdoc
       */
      public function filter($possibleValues) {
        return array_values(array_filter($possibleValues, function($value){
            return (strlen($value) > 5);
        }));
      }
  
  }
```

While this custom method doesn't do anything extraordinary, it's a basic example of the interfaces for a lexical method.

```php
<?php


  use Celestial\Lexicology\Suggestion;
  use Lexicology\Test\Method\CustomMethod;
  
  $suggestionOptions = [
    'string',  
    'strings',  
    'new string',  
    'value',  
    'variable'  
  ];
  
  $suggestion = new Suggestion();
  $suggestions = $suggestion->suggestFields('string', $suggestionOptions, CustomMethod::class);
  
  print_r($suggestions);
  
//Array
//(
//    [0] => new string
//    [1] => strings
//    [2] => variable
//    [3] => string
//)
```