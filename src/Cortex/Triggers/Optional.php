<?php
/*
 * This file is part of Rivescript-php
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Axiom\Rivescript\Cortex\Triggers;

use Axiom\Rivescript\Cortex\Input;
use Axiom\Rivescript\Traits\Regex;

/**
 * Arrays class
 *
 * The Optional class determines if a provided trigger
 * is an Optional type.
 *
 * PHP version 7.4 and higher.
 *
 * @category Core
 * @package  Cortext\Triggers
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/axiom-labs/rivescript-php
 * @since    0.4.0
 */
class Optional extends Trigger
{
    use Regex;

    /**
     * The Regex pattern to find sets
     * in the trigger.
     *
     * Note: This pattern ignores the set if a @ character
     * is inside to make sure we don't confuse them with arrays.
     *
     * @var string
     */
    protected string $pattern = "/(\[)(?!\@)(.+?=*)(\])/ui";

    /**
     * Parse the trigger.
     *
     * @return bool|string
     */
    public function parse(string $trigger, Input $input): bool
    {
        if ($this->matchesPattern($this->pattern, $trigger) === true) {
            $triggerString = $trigger;
            $matches = $this->getMatchesFromPattern($this->pattern, $triggerString);
            $sets = [];

            /**
             * Replace every "set" in the trigger to their index number
             * found in the string.
             *
             * Example:
             *
             * "I (am|love) a robot. I like (my|style)"
             *
             * Will be replaced with:
             *
             * "I {0} a robot. I like {1}"
             */
            foreach ($matches as $index => $match) {
                $set = explode("|", $match[2]);

                if (count($set) > 0) {
                    $triggerString = str_replace($match[0], "{{$index}}", $triggerString);
                    $sets [] = $set;
                }
            }

            $combinations = $this->getCombinations(...$sets);

            if (count($combinations) > 0) {
                $sentences = [];

                foreach ($combinations as $combination) {
                    $tmp = $triggerString;
                    foreach ($combination as $index => $string) {
                        $tmp = str_replace("{{$index}}", $string, $tmp);
                    }

                    $sentences [] = $tmp;
                }

                $result = array_filter($sentences, static function (string $sentence) use ($input) {
                    return (strtolower($sentence) === strtolower($input->source()));
                });

                if (count($result) > 0) {
                    return $input->source();
                }
            }
        }
        return false;
    }

    /**
     * Create a set of possible combinations for given arrays.
     *
     * Note: This function is taken from stackoverflow.com
     * first posted by Guilhermo Luna and later edited by user Amlette.
     *
     * @see https://stackoverflow.com/questions/8567082/how-to-generate-in-php-all-combinations-of-items-in-multiple-arrays/33259643#33259643
     *
     * @param array ...$arrays A set of arrays to combine.
     *
     * @return array|array[]
     *
     */
    private function getCombinations(array ...$arrays): array
    {
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}