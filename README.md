[![Build Status](https://travis-ci.org/Celest/lexicology.svg?branch=master)](https://travis-ci.org/Celest/lexicology)

# Lexicology

PHP lexicology library.

- Suggests values from an array based on a lexical comparison
- Return a 'rate' for sorting an array based on lexical comparison
- Pick best match from an array
- Pick best match associations between arrays

## Core Lexical Comparisons

- [levenshtein](http://php.net/manual/en/function.levenshtein.php) using `LevenshteinDistance`
- [preg_grep](http://php.net/manual/en/function.preg_grep.php) using `PregGrep`
- [similar_text](http://php.net/manual/en/function.similar_text.php) using `Similarity`
- [soundex](http://php.net/manual/en/function.sounded.php) using `Soundex`

Also allows custom lexical comparison by extending `Lexicology\Method\AbstractMethod` and implementing `Lexicology\Method\MethodInterface`. See [Custom Method](#custom-method)

## Use

### Suggestion
The `Suggestion` class can suggest fields or values from an array that match closely to a needle value.
The default method is [PregGrep](#PregGrep) but that can be changed to any of the other methods or a custom method.
```php
<?php

  use Lexicology\Suggestion;
  
  $suggestionOptions = [
    'string',  
    'new string',  
    'value',  
    'variable'  
  ];
  
  $suggestion = new Suggestion();
  $suggestions = $suggestion->suggestFields('string', $suggestionOptions);
  
  print_r($suggestions);
  
//Array
//(
//    [0] => string
//    [1] => new string
//)
```

### Custom Method
A custom Method definition must implement either a `FilterInterface` or `RateInterface`

```php
<?php
  use Lexicology\Method\AbstractMethod;
  use Lexicology\Method\Interfaces\FilterInterface;
  use Lexicology\Method\Interfaces\RateInterface;
  
  class CustomMethod extends AbstractMethod implements RateInterface, FilterInterface
  {
      /**
       * Return a sort value if either a or b match.
       * 
       * @inheritdoc 
       */
      public function rate($a, $b) {
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

While this custom method doesn't do anything extraordinary, it's a basic example of the interfaces for a lecical method.

```php
<?php


  use Lexicology\Suggestion;
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
//    [0] => string
//    [1] => new string
//    [3] => variable
//)
```