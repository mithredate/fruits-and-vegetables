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
}
