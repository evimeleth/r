<?php
/*
 * This file is part of Rivescript-php
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Axiom\Rivescript\Cortex\Tags;

use Axiom\Rivescript\Cortex\Input as SourceInput;

/**
 * Env class
 *
 * This class is responsible parsing the <env> tag.
 *
 * PHP version 7.4 and higher.
 *
 * @category Core
 * @package  Cortext\Tags
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/axiom-labs/rivescript-php
 * @since    0.4.0
 */
class Env extends Tag
{
    /**
     * Determines where this tag is allowed to
     * be used.
     *
     * @var array<string>
     */
    protected array $allowedSources = ["response", "trigger"];

    /**
     * Regex expression pattern.
     *
     * @var string
     */
    protected string $pattern = "/<env (.*[a-zA-Z0-9])=(.*[a-zA-Z0-9])>|<env (.*[a-zA-Z0-9])>/i";

    /**
     * Parse the source.
     *
     * @param string      $source The string containing the Tag.
     * @param SourceInput $input  The input information.
     *
     * @return string
     */
    public function parse(string $source, SourceInput $input): string
    {
        if (!$this->sourceAllowed()) {
            return $source;
        }

        if ($this->hasMatches($source)) {
            $matches = $this->getMatches($source);
            $variables = synapse()->memory->global();

            foreach ($matches as $match) {
                if (count($match) === 4) {
                    $source = str_replace($match[0], $variables[$match[3]] ?? "undefined", $source);
                } elseif (count($match) === 3) {
                    [$key, $value] = $match;

                    synapse()->memory->global()->put($key, $value);
                    $source = str_replace($match[0], '', $source);
                }
            }
        }

        return $source;
    }

    /**
     * Return the tag that the class represents.
     *
     * @return string
     */
    public function getTagName(): string
    {
        return "env";
    }
}
