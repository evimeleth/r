<?php

namespace Axiom\Rivescript\Cortex;

use Axiom\Rivescript\Exceptions\ParseException;
use SplFileObject;

class Brain
{
    /**
     * @var Branch
     */
    protected $topics;

    protected $strict = false;

    /**
     * Create a new instance of Brain.
     */
    public function __construct()
    {
        $this->createTopic('random');
    }

    /**
     * Teach the brain contents of a new file source.
     *
     * @param string $file
     * @throws ParseException
     */
    public function teach($file)
    {
        $commands   = synapse()->commands;
        $script       = new SplFileObject($file);
        $lineNumber = 0;

        while (! $script->eof()) {
            $currentCommand = null;
            $line           = $script->fgets();
            $node           = new Node($line, $lineNumber++);

            if ($node->isInterrupted() or $node->isComment()) {
                continue;
            }

            $error = $node->checkSyntax();

            if ($error) {
                $line = str_replace(["\r", "\n"], '', $line);
                $syntax_error = "Syntax error in {$file} line {$lineNumber}: {$error} (near: $line)";
                if ($this->strict === true) {
                    die($syntax_error);
                } else {
                    throw new ParseException($syntax_error);
                }
            }

            $commands->each(function ($command) use ($node, $currentCommand) {
                $class = "\\Axiom\\Rivescript\\Cortex\\Commands\\$command";
                $commandClass = new $class();

                $result = $commandClass->parse($node, $currentCommand);

                if (isset($result['command'])) {
                    $currentCommand = $result['command'];

                    return false;
                }
            });
        }
    }

    public function topic($name = null)
    {
        if (is_null($name)) {
            $name = synapse()->memory->shortTerm()->get('topic') ?: 'random';
        }

        if (! isset($this->topics[$name])) {
            return null;
        }

        return $this->topics[$name];
    }

    public function createTopic($name)
    {
        $this->topics[$name] = new Topic($name);

        return $this->topics[$name];
    }
}
