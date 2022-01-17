<?php
/*
 * This file is part of Rivescript-php
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Axiom\Rivescript\Cortex\Conditions;

use Axiom\Rivescript\Contracts\Condition as ConditionContract;

/**
 * Equals class
 *
 * This class handles == equals condition.
 *
 * aliases:
 *  - eq
 *
 * PHP version 7.4 and higher.
 *
 * @category Core
 * @package  Cortext\Conditions
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/axiom-labs/rivescript-php
 * @since    0.4.0
 */
class Equals extends Condition implements ConditionContract
{
    /**
     * Handle conditions '==' or its alias 'eq'.
     *
     * @param string $source The source to parse.
     *
     * @return false|string
     */
    public function parse(string $source)
    {
        $pattern = "/^([\S]+) (==|eq) ([\S]+) =>\s(.*)$/";

        if ($this->matchesPattern($pattern, $source) === true) {
            $matches = $this->getMatchesFromPattern($pattern, $source);

            if (isset($matches[0]) === true and count($matches[0]) >= 2) {
                if ($matches[0][1] === $matches[0][3]) {
                    return $matches[0][4];
                }
            }
        }

        return false;
    }
}