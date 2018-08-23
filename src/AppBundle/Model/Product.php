<?php declare(strict_types=1);

namespace AppBundle\Model;

class Product
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $content;

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public static function create(string $title, string $content): self
    {
        $product = new self;
        $product->title = $title;
        $product->content = $content;

        return $product;
    }
}
