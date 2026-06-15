# PHP Logic Toolkit

PHP Logic Toolkit is a focused command-line project for trying small algorithms from the terminal. It is built as a portfolio-friendly PHP app with a clear entry point, typed service classes, examples, and tests.

## Features

- Search a numeric list with linear or binary search
- Sort a list with insertion sort or quick sort
- Check text for palindromes and anagrams
- Calculate gcd, factorial, and Fibonacci values
- Print JSON output that is easy to inspect or pipe into another tool

## Usage

```bash
php bin/logic-toolkit search binary --list=1,3,5,8,13 --target=8
php bin/logic-toolkit sort quick --list=9,4,7,1
php bin/logic-toolkit text palindrome --value="Never odd or even"
php bin/logic-toolkit number gcd --a=84 --b=30
```

## Development

```bash
composer install
composer run-script test
composer run-script style
```

The project is intentionally small. Each command maps to a short service class in `src/`, so it is easy to review, extend, and explain during an interview or client discussion.
