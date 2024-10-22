<?php

namespace App\Entity;

use App\Repository\WeatherdataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherdataRepository::class)]
class Weatherdata
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'weatherdatas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $temperature_celsius = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $wind_speed = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $humidity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 0)]
    private ?string $pressure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTemperatureCelsius(): ?float
    {
        return $this->temperature_celsius;
    }

    public function setTemperatureCelsius(string $temperature_celsius): static
    {
        $this->temperature_celsius = $temperature_celsius;

        return $this;
    }

    public function getWindSpeed(): ?string
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(string $wind_speed): static
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getPressure(): ?string
    {
        return $this->pressure;
    }

    public function setPressure(string $pressure): static
    {
        $this->pressure = $pressure;

        return $this;
    }
}
