<?php


namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;


class ParseCommand extends  Command
{


    protected function configure()
    {

        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:parse')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new parse API.symfony.com.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//namespace
        $html = file_get_contents('http://api.symfony.com/3.2/');

        $crawler = new Crawler($html);
        $row = $crawler->filter('div.namespace-container > ul > li > a');

       foreach ($row as $item) {
            $urlSymf = $item->getAttribute("href");
            $URLname = $item->textContent;

            //var_dump ($urlSymf, $URLname);
        }
//class

        $forClass = $crawler->filter
        ('div.content > div.right-column > div.page-content > div.page-header > div.row > div > a');


        foreach ($forClass as $item){

            $classUrl = $item->getAttribute("href");
            var_dump($classUrl);
        }


      //  $forInterface = $crawler->filter();
    }

}

