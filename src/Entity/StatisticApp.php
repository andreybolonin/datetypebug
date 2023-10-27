<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatisticApp.
 */
#[ORM\Table]
#[ORM\Entity]
class StatisticApp
{

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    private $id;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }
}
