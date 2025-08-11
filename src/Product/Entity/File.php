<?php

namespace App\Product\Entity;


use App\Product\Entity\File\FileExtension;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FilePath;
use App\Product\Entity\File\FileSize;
use App\Shared\Domain\ValueObject\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_files')]
class File
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    #[ORM\Column(type: 'file_name', unique: true)]
    private FileName $filename;
    #[ORM\Column(type: 'file_path', unique: true)]
    private FilePath $path;
    #[ORM\Column(type: 'file_extension')]
    private FileExtension $extension;
    #[ORM\Column(type: 'file_size')]
    private FileSize $size;
    #[ORM\OneToOne(targetEntity: Product::class, inversedBy: 'file')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
    private Product $product;
    public function __construct(Id $id, FileName $filename, FileExtension $extension, FilePath $path, FileSize $size, Product $product)
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->path = $path;
        $this->extension = $extension;
        $this->size = $size;
        $this->product = $product;
    }
    public function getPath(): string
    {
        return $this->path->getValue();
    }
    public function getFilename(): string
    {
        return $this->filename->getValue();
    }
    public function getExtension(): string
    {
        return $this->extension->getValue();
    }
    public function getSize(): int
    {
        return $this->size->getValue();
    }
    public function isFileExists(): bool
    {
        return $this->path->isFileExists();
    }
    public function deleteFile(): void
    {
        $this->path->deleteFile();
    }
}
