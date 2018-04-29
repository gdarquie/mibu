<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SaveDBCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:db:export')
            ->setDescription('Export de la base de données')
            ->setHelp("Cette commande permet d'exporter le contenu de la BD pour pouvoir en conserver une version de sauvegarde.");
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Export de la BD',
            '============',
            '',
        ]);

        //export de toutes les tables

        // outputs a message followed by a "\n"
        $output->writeln("Attention, le script va être lancé.");

        // outputs a message without adding a "\n" at the end of the line
        $output->write('Whoa! L\'export est achevé.');
    }
}