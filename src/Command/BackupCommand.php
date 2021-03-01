<?php

namespace Vldmrk\PhpbuBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use phpbu\App\Configuration\Loader\Factory as PhpbuConfigLoaderFactory;
use Vldmrk\PhpbuBundle\Configuration\Exception;
use Vldmrk\PhpbuBundle\Helper\Printer;


class BackupCommand extends Command {


    /**
     * phpbu App runner.
     *
     * @var \phpbu\App\Runner
     */
    protected $runner;

    /**
     * @var string
     */
    protected $configuration;

    public function __construct(\phpbu\App\Runner $runner, ?string $configuration)
    {
        $this->runner = $runner;
        $this->configuration = $configuration;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('phpbu:backup')
            ->addOption('phpbu-simulate', null, InputOption::VALUE_NONE, 'Perform a trial run with no changes made.')
            ->addOption('phpbu-verbose', null, InputOption::VALUE_NONE, 'Output more verbose information.')
            ->addOption('phpbu-debug', null, InputOption::VALUE_NONE, 'Display debugging information during backup generation.')
            ->setDescription('Phpbu backup')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->configuration);

        $configuration = $this->createConfiguration();

        // add a printer for some output
        $configuration->addLogger($this->createPrinter($input, $output));

        // finally execute the backup
        $result = $this->runner->run($configuration);


        return $result->wasSuccessful() ? Command::SUCCESS : Command::FAILURE;
    }


    /**
     * Creates a phpbu configuration.
     *
     * @return \phpbu\App\Configuration
     */
    protected function createConfiguration()
    {
        // check if a phpbu xml/json config file is configured
        if (!empty($this->configuration)) {
            // load xml or json configurations
            $configLoader  = PhpbuConfigLoaderFactory::createLoader($this->configuration);
            $configuration = $configLoader->getConfiguration($this->runner->getFactory());
        } else {
            throw new Exception("File {$this->configuration} was not found.");
        }

        return $configuration;
    }

    /**
     * Create a logger/printer to do some output.
     *
     * @return Printer
     */
    protected function createPrinter(InputInterface $input, OutputInterface $output)
    {
        $verbose  = (bool) $input->getOption('phpbu-verbose');
        $debug    = (bool) $input->getOption('phpbu-debug');
        $simulate = (bool) $input->getOption('phpbu-simulate');
        return new Printer($output, $verbose, ($debug || $simulate));
    }


}