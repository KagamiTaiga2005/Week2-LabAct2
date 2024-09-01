<?php

class Book {
    public $title;
    protected $author;
    private $price;

    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    public function getDetails() {
        return "Title: {$this->title}, Author: {$this->author}, Price: \${$this->price}";
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function __call($name, $arguments) {
        if ($name == 'updateStock') {
            echo "Stock updated for '{$this->title}' with arguments: " . implode(", ", $arguments) . "\n";
        } else {
            echo "Method '{$name}' not found in class " . __CLASS__ . "\n";
        }
    }
}

class Library {
    private $books = [];
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addBook(Book $book) {
        $this->books[$book->title] = $book;
    }

    public function removeBook($title) {
        if (isset($this->books[$title])) {
            unset($this->books[$title]);
            echo "Book '{$title}' removed from the library.\n";
        } else {
            echo "Book '{$title}' not found in the library.\n";
        }
    }

    public function listBooks($afterRemoval = false) {
        if (empty($this->books)) {
            echo "No books in the library.\n";
            return;
        }
        echo $afterRemoval ? "Books in the library after removal:\n" : "Books in the library:\n";
        foreach ($this->books as $book) {
            echo $book->getDetails() . "\n";
        }
    }

    public function __destruct() {
        echo "The library '{$this->name}' is now closed.\n";
    }
}

$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 12.99);
$book2 = new Book("1984", "George Orwell", 8.99);

$library = new Library("City Library");

$library->addBook($book1);
$library->addBook($book2);

$book1->setPrice(12.99);
$book1->updateStock(50);

$library->listBooks();

$library->removeBook("1984");
$library->listBooks(true);

unset($library);
?>
