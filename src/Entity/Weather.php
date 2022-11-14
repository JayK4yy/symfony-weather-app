<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherRepository::class)]
class Weather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cities $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $temp_night = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $temp_day = null;

    #[ORM\Column(nullable: true)]
    private ?int $rain_prob = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0', nullable: true)]
    private ?string $wind_speed = null;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTempNight(): ?string
    {
        return $this->temp_night;
    }

    public function setTempNight(string $temp_night): self
    {
        $this->temp_night = $temp_night;

        return $this;
    }

    public function getTempDay(): ?string
    {
        return $this->temp_day;
    }

    public function setTempDay(string $temp_day): self
    {
        $this->temp_day = $temp_day;

        return $this;
    }

    public function getRainProb(): ?int
    {
        return $this->rain_prob;
    }

    public function setRainProb(?int $rain_prob): self
    {
        $this->rain_prob = $rain_prob;

        return $this;
    }

    public function getWindSpeed(): ?string
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(?string $wind_speed): self
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->id,
            $this->date->format('d-m-Y'),
            $this->temp_night,
            $this->temp_day,
            $this->rain_prob,
            $this->wind_speed
        ];
    }
}
