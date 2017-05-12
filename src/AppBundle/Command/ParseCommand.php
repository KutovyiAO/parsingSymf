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
            ->setName('app:parse')
            ->setDescription('Creates a new parse API.symfony.com.')
            ->setHelp('This command allows you to create a user...')
        ;
    }

    /**
     * @param InputInterface $input
     *
     * @param OutputInterface $output
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();

        $html = file_get_contents('http://api.symfony.com/3.2/');

        $crawler = new Crawler($html);

//namespace

        $forNamespace = $crawler->filter('div.namespace-container > ul > li > a');

       foreach ($forNamespace as $item) {

               $urlSymf = $item->getAttribute("href");
               $urlName = $item->textContent;

               $namespace = new NamespaceSymfony();
               $namespace->setUrl($urlSymf);
               $namespace->setName($urlName);
               $em->persist($namespace);

// Class

           $htmlNamespaceForClass = file_get_contents('http://api.symfony.com/3.2/'. $urlSymf);
           $CrawlerNamespace = new Crawler($htmlNamespaceForClass);

           $forClass = $CrawlerNamespace->filter
           ('div#page-content > div.container-fluid.underlined > div.row > div.col-md-6 > a');

           foreach ($forClass as $item) {

               $classUrl  = $item->getAttribute("href");
               $className = $item->textContent;
               $class = new ClassSymfony();

               $class->setUrl($classUrl);
               $class->setName($className);
               $class->setNamespace($namespace);
               $em->persist($class);
           }

//Interface

           $htmlNamespaceForInt = file_get_contents('http://api.symfony.com/3.2/'. $urlSymf);
           $CrawlerInterface = new Crawler($htmlNamespaceForInt);

           $forInterface = $CrawlerInterface->filter
           ('div.container-fluid.underlined > div.row > div.col-md-6 > em > a' );

           foreach ($forInterface as $item) {

                $interUrl = $item->getAttribute("href");
                $interName = $item->textContent;

                $interface = new InterfaceSymfony();

                $interface->setUrl($interUrl);
                $interface->setName($interName);
                $interface->setNamespace($namespace);
                $em->persist($interface);

        }

    }
        $em->flush();
    }
}

