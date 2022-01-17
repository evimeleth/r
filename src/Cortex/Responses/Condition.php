<?php
/*
 * This file is part of Rivescript-php
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Axiom\Rivescript\Cortex\Responses;

use Axiom\Rivescript\Contracts\Response as ResponseContract;

/**
 * Condition class
 *
 * The Condition class determines the type of condition and
 * executes it.
 *
 * PHP version 7.4 and higher.
 *
 * @category Core
 * @package  Cortext\Responses
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/axiom-labs/rivescript-php
 * @since    0.4.0
 */
class Condition extends Response implements ResponseContract
{

    /**
     * Handle Conditions, if the source is a Condition
     * then we need to handle the conditions.
     *
     * @return false|mixed
     */
    public function parse()
    {
        if ($this->responseQueueItem()->getCommand() === '*') {
            foreach (synapse()->conditions as $class) {
                $class = "\\Axiom\\Rivescript\\Cortex\\Conditions\\{$class}";
                $class = new $class();

                $result = $class->parse($this->source());

                if ($result !== false) {
                    return $result;
                }
            }
        }
        return false;
    }

    /**
     * Indicate the type of response this
     * class handles.
     *
     * @return string
     */
    public function getType(): string
    {
        return 'condition';
    }
}