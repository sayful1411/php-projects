<?php
class Transaction
{
    private $amount;
    private $categoryName;
    private $categoryType;
    private $date;

    public function __construct($amount, $category, $date)
    {
        $this->amount = $amount;
        $this->categoryName = $category->getName();
        $this->categoryType = $category->getType();
        $this->date = $date;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCategoryName()
    {
        return $this->categoryName;
    }


    public function getCategoryType()
    {
        return $this->categoryType;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setAmount($newAmount)
    {
        $this->amount = $newAmount;
    }

    public function setCategory($newCategory)
    {
        $this->categoryName = $newCategory;
    }
}
