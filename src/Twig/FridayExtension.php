<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FridayExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [

            new TwigFilter('friday', [$this, 'isFriday']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('friday', [$this, 'isFriday']),
        ];
    }

    public function isFriday()
    {
        $date = new \DateTime('2020-01-17');
        if($date->format('D') == 'Fri'){
            return true;
        }else{
            return null;
        }
    }
}
