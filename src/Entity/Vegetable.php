<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\VegetableRepository;
use App\Utils\Unit;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VegetableRepository::class)]
#[ORM\Table(name: 'vegetables')]
final class Vegetable
{
}
