<?php


namespace AppBundle\Command;

use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;


class ParseCommand extends  ContainerAwareCommand
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
        $em = $this->getContainer()->get('doctrine')->getManager();

        $html = file_get_contents('http://api.symfony.com/3.2/');

        $crawler = new Crawler($html);

        $forNamespace = $crawler->filter('div.namespace-container > ul > li > a');

       foreach ($forNamespace as $item) {

           $urlSymf = $item->getAttribute("href");
           $urlName = $item->textContent;

           $namespace = new NamespaceSymfony();
           $namespace->setUrl($urlSymf);
           $namespace->setName($urlName);
           $em->persist($namespace);
           $em->flush();
        }
//class


        $forClass = $crawler->filter
        ('div.content > div.right-column > div.page-content > div.page-header > div.row > div.col-md-6 > a ');


        foreach ($forClass as $item) {

            $classUrl = $item->getAttribute("href");
            $className = $item->textContent;

            $class = new ClassSymfony();

            $class->setUrl($classUrl);
            $class->setName($className);
            $class->setNamespace($namespace);
            $em->persist($class);
            $em->flush();
        }

//Interface
       $forInterface = $crawler->filter
           ('div.content > div.right-column > div.page-content > div.page-header > div.row > div.col-md-6 > em > a' );

        foreach ($forInterface as $item) {

            $interUrl = $item->getAttribute("href");
            $interName = $item->textContent;

            $interface = new InterfaceSymfony();

            $interface->setUrl($interUrl);
            $interface->setName($interName);
            $interface->setNamespace($namespace);
            $em->persist($interface);
            $em->flush();
        }


    }

}

