<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\FruitRepository;
use App\Utils\Unit;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
#[ORM\Table(name: 'fruits')]
final class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotNull]
    private string $name;

    #[ORM\Column(name: 'quantity_in_gram', type: Types::INTEGER)]
    #[Assert\NotNull()]
    private int $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity, Unit $unit): void
    {
        $this->quantity = $unit->toGrams($quantity);
    }
}
