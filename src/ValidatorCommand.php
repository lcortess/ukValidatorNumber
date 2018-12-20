<?php
namespace Console;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ValidatorCommand extends Command
{
    protected function configure()
    {
        $this -> setName('validate')
            -> setDescription('Validates phone numbers for the UK')
            -> setHelp('Define a list (path to the file list) of numbers and the name of the output file \r The list of numbers must be separated by commas')
            -> addArgument('list', InputArgument::REQUIRED, 'The file with the list of numbers is required')
            -> addArgument('output', InputArgument::REQUIRED, 'The name of the output file  is required');
    }

    /**
     * This function pretends to use a "lookup" service to look for the real carrier of the number
     * but since all those services needs a registration token and pay for the service
     * this function will always return "Telefonica U.K."
     */
    private function getCarrier ($number)
    {
        return "Telefonica U.K.";
    }

    private function getNumberRecord ($number)
    {
        $pattern = '/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/';
        preg_match($pattern, $number, $matches);

        return [
            $number,
            $this -> getCarrier($number),
            count($matches) > 0 ? "Yes" : "No"
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output -> writeln('Validating numbers...');
        $fileSystem = new Filesystem();

        if ($fileSystem->exists($input -> getArgument('list'))) {
            $output -> writeln('Creating file...');
            $numbersList = file_get_contents($input -> getArgument('list'));
            $numbersList = explode(',', $numbersList);

            $handleFile = fopen($input -> getArgument('output'), 'w+');
            fputcsv($handleFile, ['Phone Number', 'Carrier', 'Status']);
            
            foreach($numbersList as $number) {
                fputcsv( $handleFile, $this->getNumberRecord(trim($number)) );
            }

            fclose($handleFile);
            $output -> writeln('Done.');

        } else {
            $output -> writeln('The file for the numbers list is not valid');
        }
    }
}