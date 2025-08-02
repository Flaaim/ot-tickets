<?php

namespace App\Product\Entity\File;

use Webmozart\Assert\Assert;

class FullName
{
    private string $value;
    private FileName $name;
    private FileExtension $extension;

    public function __construct(FileName $name, FileExtension $extension)
    {
        $this->name = $name;
        $this->extension = $extension;

        $fullName = $name->getValue(). '.' . $extension->getValue();

        $regex = '/^[a-f0-9]{8}-([a-f0-9]{4}-){3}[a-f0-9]{12}\.[a-z0-9]+$/i';
        Assert::regex($fullName, $regex);

        $this->value = $fullName;
    }
    public function getValue(): string
    {
        return $this->value;
    }

    public function getExtension(): string
    {
        return $this->extension->getValue();
    }
    public function getName(): string
    {
        return $this->name->getValue();
    }
}
