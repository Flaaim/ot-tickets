<?php

namespace App\Product\Entity;

use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'id', unique: true)]
        private readonly Id                $id,
        #[ORM\Column(type: 'string', length: 255)]
        private string                     $name,
        #[ORM\Column(type: 'text')]
        private string                     $description,
        #[ORM\Column(type: 'price')]
        private Price                      $price,
        #[ORM\Column(type: 'string', length: 16)]
        private string                     $cipher,
        #[ORM\Column(type: 'datetime_immutable')]
        private readonly DateTimeImmutable $updatedAt,
        #[ORM\Column(type: 'status')]
        private Status                     $status,
        #[ORM\OneToOne(targetEntity: File::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
        private ?File                      $file = null
    ) {
        Assert::minLength($this->name, 3);
        Assert::minLength($this->description, 10);
        Assert::regex($this->cipher, '/^[A-Za-z0-9-]+$/');
        Assert::notNull($status);
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getCipher(): string
    {
        return $this->cipher;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
    public function getStatus(): Status
    {
        return $this->status;
    }
    public function changePrice(Price $price): void
    {
        $this->price = $price;
    }
    public function changeName(?string $name): void
    {
        $this->name = $name;
    }
    public function changeDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function changeCipher(?string $cipher): void
    {
        $this->cipher = $cipher;
    }

    public function archive(): void
    {
        if($this->status->isArchived()){
            throw new \DomainException('Product is already archived.');
        }
        $this->status = Status::archive();
    }

    public function activate(): void
    {
        if($this->status->isActive()){
            throw new \DomainException('Product is already active.');
        }
        $this->status = Status::active();
    }
    public function addFile(File $file): void
    {
        if($this->file !== null && $this->file->isFileExists()){
            $this->file->deleteFile();
        }
        $this->file = $file;
    }
}
