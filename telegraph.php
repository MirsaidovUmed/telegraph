<?php

class TelegraphText
{
    private string $title;
    private string $text;
    private string $author;
    public string $slug;
    private DateTimeImmutable $published;

    public function __construct(string $author, string $slug)
    {
        $this->author = $author;
        $this->slug = $slug;
        $this->published = new DateTimeImmutable();
    }

    public function storeText(): void
    {
        $textStorage = [
            'text' => $this->text,
            'title' => $this->title,
            'author' => $this->author,
            'published' => $this->published,
        ];
        $serializeTextStorage = serialize($textStorage);
        file_put_contents($this->slug, $serializeTextStorage);
    }

    public function loadText(): string
    {
        if (file_exists($this->slug)) {
            $fileContent = file_get_contents($this->slug);
            if (!empty($fileContent)) {
                $textStorage = unserialize($fileContent);
                $this->title = $textStorage['title'];
                $this->text = $textStorage['text'];
                $this->author = $textStorage['author'];
                $this->published = $textStorage['published'];
            }
        }
        return $this->text;
    }

    public function editText(string $title, string $text): void
    {
        $this->title = $title;
        $this->text = $text;
    }
}

abstract class Storage
{
    abstract public function create(object $object): string;

    abstract public function read(string $slug);

    abstract public function update(object $object, string $slug);

    abstract public function delete(string $slug);

    abstract public function list(): array;
}

abstract class User
{
    private int $id;
    private string $name;
    private string $role;

    abstract public function getTextsToEdit(): array;
}

class FileStorage extends Storage
{
    public string $dir = "file_folder";

    public function create(object $object): string
    {
        $slug = $object->slug . '_' . date('Ymd');
        $count = 0;
        while (file_exists($this->dir . DIRECTORY_SEPARATOR . $slug . ($count > 0 ? "_$count" : '') . '.txt')) {
            $count++;
        }
        if ($count > 0) {
            $slug .= "_$count";
        }
        $object->slug = $slug;
        file_put_contents($this->dir . DIRECTORY_SEPARATOR . $slug . '.txt', serialize($object));
        return $slug;
    }

    public function read(string $slug)
    {
        if (file_exists($this->dir . DIRECTORY_SEPARATOR . $slug . '.txt')) {
            $object = unserialize(file_get_contents($this->dir . DIRECTORY_SEPARATOR . $slug . '.txt'));
            return $object;
        }
        return null;
    }

    public function update(object $object, string $slug): string
    {
        if (file_exists($this->dir . DIRECTORY_SEPARATOR . $slug . '.txt')) {
            file_put_contents($this->dir . DIRECTORY_SEPARATOR . $slug . '.txt', serialize($object));
        }
        return $slug;
    }

    public function delete(string $slug): string
    {
        if (file_exists($this->dir . DIRECTORY_SEPARATOR . $slug . '.txt')) {
            unlink($this->dir . DIRECTORY_SEPARATOR . $slug . '.txt');
        }
        return $slug;
    }

    public function list(): array
    {

    }
}

$warAndPeace = new TelegraphText('Leo Tolstoy', 'war-and-peace');
$warAndPeace->editText('War and Peace', 'Eh bien, mon prince. Gênes et Lucques...');

$storage = new FileStorage();
$storage->create($warAndPeace);