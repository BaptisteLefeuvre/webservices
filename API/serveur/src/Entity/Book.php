<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_publication;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="book")
     */
    private $stock;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function __construct()
    {
        $this->stock = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): self
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'author' => $this->getAuthor(),
            'date_publication' => $this->getDatePublication()
        ];
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStock(): Collection
    {
        $stockNotEmpty = (Criteria::create())->where(Criteria::expr()->gt('count', 0));

        return $this->stock->matching($stockNotEmpty);
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stock->contains($stock)) {
            $this->stock[] = $stock;
            $stock->setBook($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stock->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getBook() === $this) {
                $stock->setBook(null);
            }
        }

        return $this;
    }

    public function showStock()
    {
        $stock = [];
        foreach($this->stock as $s)
        {
            if($s->getCount() >= 1)
            {
                $stock[] = ['count' => $s->count, 'library' => $s->library, 'adress' => $s->adress, 'city' => $s->city];
            }
        }

        return $stock;

    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
