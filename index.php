<?php

class Product
{
    public $prodId;
    public $prodName;
    public $price;
    public $prodarray = array();

    public function performOperation()
    {
        while (true) {
            echo "Choose an operation:" . PHP_EOL;
            echo "1. Insert" . PHP_EOL;
            echo "2. Update" . PHP_EOL;
            echo "3. Search" . PHP_EOL;
            echo "4. Display" . PHP_EOL;
            echo "5. Delete" . PHP_EOL;
            echo "6. Sort Based On Id" . PHP_EOL;
            echo "7. ReverseSOrt based on Id" . PHP_EOL;
            echo "8. Exit" . PHP_EOL;

            $choice = readline("Enter your choice: ");

            switch ($choice) {
                case '1':
                    $this->Insert();
                    break;
                case '2':
                    $this->Update();
                    break;
                case '3':
                    $this->Search();
                    break;
                case '4':
                    $this->Display();
                    break;
                case '5':
                    $this->Delete();
                    break;
                case '6':
                    $this->SortbasedOnId();
                    break;
                case '7':
                    $this->ReverseSortbasedOnId();
                    break;
                case '8':
                    echo "Program Ended" . PHP_EOL;
                    return;
                default:
                    echo "Invalid choice. Please try again." . PHP_EOL;
            }
            echo PHP_EOL;
        }
    }


    function Insert()
    {
        $this->prodId = readline("Enter the prodId: ");
        $this->prodName = readline("Enter the product Name: ");
        $this->price = readline("Enter the price: ");

        $this->prodarray[] = array('prodId' => $this->prodId, 'prodName' => $this->prodName, 'price' => $this->price);
    }

    public function Display()
    {
        foreach ($this->prodarray as $prod) {
            echo "Product Id: " . $prod['prodId'] . PHP_EOL;
            echo "Product Name: " . $prod['prodName'] . PHP_EOL;
            echo "Price: " . $prod['price'] . PHP_EOL;
        }
    }

    public function Update()
    {
        $ch = readline("Enter 1 for updating prodId\nEnter 2 for updating product Name\nEnter 3 for updating product price");
        if ($ch == '1') {
            $this->prodId = readline("Enter the new prodId: ");
            echo "prodId updated successfully!" . PHP_EOL;
        } elseif ($ch == '2') {
            $this->prodName = readline("Enter the new product Name: ");
            echo "Product Name updated successfully!" . PHP_EOL;
        } elseif ($ch == '3') {
            $this->price = readline("Enter the new price: ");
            echo "Price updated successfully!" . PHP_EOL;
        } else {
            echo "Invalid choice. Nothing was updated." . PHP_EOL;
        }
        for ($i = 0; $i < count($this->prodarray); $i++) {
            $this->prodarray[$i] = array($this->prodId, $this->prodName, $this->price);
        }
    }

    public function Search()
    {
        $ch = readline("Enter 1 for searching via prodId\nEnter 2 for searching via Name\nEnter 3 for searching via price\nChoice: ");
        $searchValue = readline("Enter the value to search: ");
        $searchResults = array();

        if ($ch == '1') {
            $searchResults = $this->searchProduct('prodId', $searchValue);
        } elseif ($ch == '2') {
            $searchResults = $this->searchProduct('prodName', $searchValue);
        } elseif ($ch == '3') {
            $searchResults = $this->searchProduct('price', $searchValue);
        } else {
            echo "Invalid choice." . PHP_EOL;
            return;
        }

        if (count($searchResults) > 0) {
            foreach ($searchResults as $product) {
                echo "Product Found:" . PHP_EOL;
                echo "Product Id: " . $product['prodId'] . PHP_EOL;
                echo "Product Name: " . $product['prodName'] . PHP_EOL;
                echo "Price: " . $product['price'] . PHP_EOL;
                echo PHP_EOL;
            }
        } else {
            echo "Product not found." . PHP_EOL;
        }
    }


    public function Delete()
    {
        $ch = readline("Enter 1 for deleting via prodId\nEnter 2 for deleting via Name\nEnter 3 for deleting via price\nChoice: ");
        $deleteFlag = false;
        $productsToDelete = array();

        if ($ch == '1') {
            $searchValue = readline("Enter the prodId to delete: ");
            $productsToDelete = $this->searchProduct('prodId', $searchValue);
        } elseif ($ch == '2') {
            $searchValue = readline("Enter the Name to delete: ");
            $productsToDelete = $this->searchProduct('prodName', $searchValue);
        } elseif ($ch == '3') {
            $searchValue = readline("Enter the price to delete: ");
            $productsToDelete = $this->searchProduct('price', $searchValue);
        } else {
            echo "Invalid choice." . PHP_EOL;
            return;
        }

        if (count($productsToDelete) > 0) {
            echo "The following products will be deleted:" . PHP_EOL;
            foreach ($productsToDelete as $product) {
                echo "Product Id: " . $product['prodId'] . PHP_EOL;
                echo "Product Name: " . $product['prodName'] . PHP_EOL;
                echo "Price: " . $product['price'] . PHP_EOL;
                echo PHP_EOL;
            }

            $confirm = readline("Do you want to delete these products? (yes/no): ");
            if (strtolower($confirm) === 'yes') {
                foreach ($productsToDelete as $product) {
                    $this->deleteProduct('prodId', $product['prodId']);
                }
                echo "Products deleted successfully." . PHP_EOL;
            } else {
                echo "Deletion cancelled. Products were not deleted." . PHP_EOL;
            }
        } else {
            echo "Product not found. Nothing to delete." . PHP_EOL;
        }
    }

    private function deleteProduct($field, $value)
    {
        foreach ($this->prodarray as $key => $prod) {
            if ($prod[$field] == $value) {
                unset($this->prodarray[$key]);
            }
        }
    }

    public function searchProduct($field, $value)
    {
        $foundProducts = array();

        foreach ($this->prodarray as $prod) {
            if ($prod[$field] == $value) {
                $foundProducts[] = $prod;
            }
        }

        return $foundProducts;
    }
    public function SortbasedOnId()
    {
        $compareById = function ($a, $b) {
            return $a['prodId'] - $b['prodId'];
        };

        usort($this->prodarray, $compareById);

        echo "Products sorted based on productId:" . PHP_EOL;
        $this->Display();
    }
    public function ReverseSortbasedOnId()
    {
        $compareById = function ($a, $b) {
            return $b['prodId'] - $a['prodId'];
        };

        usort($this->prodarray, $compareById);

        echo "Products sorted based on productId in reverse Order:" . PHP_EOL;
        $this->Display();
    }
}

$ob = new Product();
// $ob->Insert();
// $ob->Display();
// $ob->Insert();
// $ob->Display();
// $ob->Search();
// $ob->Delete();
// $ob->Display();
$ob->performOperation();
