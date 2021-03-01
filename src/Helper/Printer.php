<?php
namespace Vldmrk\PhpbuBundle\Helper;

use phpbu\App\Result\PrinterCli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Printer
 *
 * @package    phpbu\Symfony
 */
class Printer extends PrinterCli
{
    /**
     * @var  \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * Constructor
     *
     * @param  Command $command
     * @param bool                        $verbose
     * @param bool                        $debug
     */
    public function __construct(\Symfony\Component\Console\Output\OutputInterface $output, $verbose = false, $debug = false)
    {
        $this->output = $output;
        parent::__construct($verbose, false, $debug);
    }

    /**
     * Writes a buffer out with a color sequence if colors are enabled
     * In this case we just overwrite it to skip any color handling.
     *
     * @param string $color
     * @param string $buffer
     */
    protected function writeWithColor($color, $buffer): void
    {
        $this->write($buffer . PHP_EOL);
    }

    /**
     * @param string $buffer
     */
    public function write($buffer): void
    {
        $this->output->writeln($buffer);
    }
}