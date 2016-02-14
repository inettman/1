<?php

namespace Location\PlaceBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class UpdateCountriesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('location:countries:update')
            ->setDescription('Update countries')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this
            ->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $countries = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('LocationPlaceBundle:Country')
            ->findAll();

        foreach($countries as $row) {
            $geonamesCountry = $this
                ->getContainer()
                ->get('geonames.country.service')
                ->getCountryByCode(
                    $row->getAddress(),
                    $this->getContainer()->getParameter('locale')
                );

            if (!empty($geonamesCountry)) {
                $row->setCurrencyCode($geonamesCountry->getCurrencyCode());
                $row->setPopulation($geonamesCountry->getPopulation());
                $row->setArea($geonamesCountry->getAreaInSqKm());
                $row->setIsoCode($geonamesCountry->getIsoNumeric());
                $em->persist($row);
                $em->flush();
            }
        }

        $output->writeln('Update success');
    }
}