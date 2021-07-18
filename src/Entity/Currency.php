<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true, length=3)
     */
    private $currencyCode;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $exchangeRate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct(string $name, string $currencyCode, int $exchangeRate)
    {
        $this->name = $name;
        $this->currencyCode = $currencyCode;
        $this->exchangeRate = $exchangeRate;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }
    public function getExchangeRate(): ?int
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(string $exchangeRate): self
    {
        $this->exchangeRate = $exchangeRate;

        return $this;
    }
}
