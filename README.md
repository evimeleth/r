# RiveScript-PHP
[![Source](http://img.shields.io/badge/source-axiom--labs/rivescript--php-blue.svg?style=flat-square)](https://github.com/axiom-labs/rivescript-php)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)
[![Build & Unit Test](https://github.com/axiom-labs/rivescript-php/actions/workflows/Phpunit.yml/badge.svg)](https://github.com/axiom-labs/rivescript-php/actions/workflows/Phpunit.yml)
[![Phpcs](https://github.com/axiom-labs/rivescript-php/actions/workflows/Phpcs.yaml/badge.svg)](https://github.com/axiom-labs/rivescript-php/actions/workflows/Phpcs.yaml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/rivescript-php/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/johnnymast/rivescript-php/?branch=develop)

This is a RiveScript interpreter library for PHP. RiveScript is a simple scripting language for chatbots with a friendly, easy to learn syntax.

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code.

## Documentation

Module documentation is available at <http://rivescript.readthedocs.org/>

Also check out the [**RiveScript Community Wiki**](https://github.com/aichaos/rivescript/wiki)
for common design patterns and tips & tricks for RiveScript.

## Installation
Simply install the package through Composer.

```
composer require axiom/rivescript
```

***Please Note,*** Since Rivescript-php does not (yet) have a stable version you will be installing the dev-master
version of the project.

## Integration
The RiveScript PHP interpreter is framework agnostic. As such, the interpreter can be used as is with native PHP, or with your favorite framework.

<i>example.rive</a>
```rivescript

+ hello bot
- Hello Human

```

```php

require 'vendor/autoload.php';
use \Axiom\Rivescript\Rivescript;

$message = 'hello bot';
$rivescript = new Rivescript();
$rivescript->load('example.rive');

echo $rivescript->reply($message);

```

<i>Output</i>
```bash
Hello Human
```
---

## Contributors

The Rivescript community is thankful for those who contributed to the project. Some of the people featured below contributed code or suggested tweaks to the package. Once again thanks, we could not have done it without you.


<p>
    <a href="https://github.com/axiom-labs/rivescript-php/graphs/contributors">
      <img src="https://contrib.rocks/image?repo=axiom-labs/rivescript-php" />
    </a>
</p>


For more information checkout the [authors page](Authors.md).

## Important: Working Draft

The RiveScript Working Draft (WD) is a document that defines the standards for how RiveScript should work, from an implementation-agnostic point of view. The Working Draft should be followed when contributing to the RiveScript-PHP interpreter. If any of the current implementations don't do what the Working Draft says they should, this is considered to be a bug and you can file a bug report or send a pull request.

You may find the latest version on the RiveScript website at http://www.rivescript.com/wd/RiveScript.


## License

The MIT License (MIT)

Copyright (c) 2021-2027 Axiom Labs

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


## SEE ALSO


The official RiveScript website, http://www.rivescript.com/