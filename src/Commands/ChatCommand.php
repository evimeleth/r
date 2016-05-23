<?php

namespace Vulcan\Rivescript\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Vulcan\Rivescript\Rivescript;

class ChatCommand extends Command
{
    protected $rivescript;

    public function __construct(Rivescript $rivescript)
    {
        $this->rivescript = $rivescript;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('chat')
             ->setDescription('Load in a Rivescript brain instance to chat with')
             ->addArgument('brain', InputArgument::REQUIRED, 'Your Rivescript brain instance');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $brain = $input->getArgument('brain');

        $this->rivescript->loadFile($brain);

        $this->waitForUserInput($input, $output);
    }

    protected function waitForUserInput($input, $output)
    {
        $helper   = $this->getHelper('question');
        $question = new Question('<info>You > </info>');

        $message = $helper->ask($input, $output, $question);

        $this->getBotResponse($input, $output, $message);
    }

    protected function getBotResponse($input, $output, $message)
    {
        $bot      = 'Bot > ';
        $response = '<info>No response.</info>';

        $output->writeln($bot.$response);

        $this->waitForUserInput($input, $output);
    }
}
