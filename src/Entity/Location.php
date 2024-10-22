<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 2)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $longitude = null;

    /**
     * @var Collection<int, Weatherdata>
     */
    #[ORM\OneToMany(targetEntity: Weatherdata::class, mappedBy: 'location')]
    private Collection $weatherdatas;

    public function __construct()
    {
        $this->weatherdatas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, Weatherdata>
     */
    public function getWeatherdatas(): Collection
    {
        return $this->weatherdatas;
    }

    public function addWeatherdata(Weatherdata $weatherdata): static
    {
        if (!$this->weatherdatas->contains($weatherdata)) {
            $this->weatherdatas->add($weatherdata);
            $weatherdata->setLocation($this);
        }

        return $this;
    }

    public function removeWeatherdata(Weatherdata $weatherdata): static
    {
        if ($this->weatherdatas->removeElement($weatherdata)) {
            // set the owning side to null (unless already changed)
            if ($weatherdata->getLocation() === $this) {
                $weatherdata->setLocation(null);
            }
        }

        return $this;
    }
}
