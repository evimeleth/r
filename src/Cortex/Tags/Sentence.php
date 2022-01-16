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
 * SpecialChars class
 *
 * This class parses the {sentence}{/sentence} tag.
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
class Sentence extends Tag
{
    /**
     * Determines where this tag is allowed to
     * be used.
     *
     * @var array<string>
     */
    protected array $allowedSources = ["response"];

    /**
     * Regex expression pattern.
     *
     * @var string
     */
    protected string $pattern = "/({)sentence(})(.+?)({)\/sentence(})|(<)sentence(>)/u";

    /**
     * Parse the source.
     *
     * @param  string       $source  The string containing the Tag.
     * @param  SourceInput  $input   The input information.
     *
     * @return string
     */
    public function parse(string $source, SourceInput $input): string
    {
        if (!$this->sourceAllowed()) {
            return $source;
        }

        if ($this->hasMatches($source)) {
            $matches = $this->getMatches($source)[0];
            $wildcards = synapse()->memory->shortTerm()->get("wildcards");

            if ($matches[0] === '<sentence>' && is_array($wildcards) === true && count($wildcards) > 0) {
                $sub = $wildcards[0];
            } elseif ($matches[1] === '{' && isset($matches[3])) {
                $sub = $matches[3];
            } else {
                $sub = "undefined";
            }

            if ($sub !== "undefined") {
                if (strpos($sub, '.') > -1) {
                    $parts = explode('.', $sub);
                    if (count($parts) !== 0) {
                        array_walk($parts, static function (&$part) {
                            $part = ucfirst(trim($part));
                        });
                    }

                    $sub = implode('.', $parts);
                } else {
                    $sub = ucfirst($sub);
                }
            }

            $source = str_replace($matches[0], $sub, $source);
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
        return "sentence";
    }
}
