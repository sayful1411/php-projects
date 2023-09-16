<?php
class Tracker
{
    private $incomeDataFile;
    private $expenseDataFile;
    private $incomeTransactions = [];
    private $expenseTransactions = [];
    private $categories = [];

    public function __construct($incomeDataFile, $expenseDataFile)
    {
        $this->incomeDataFile = $incomeDataFile;
        $this->expenseDataFile = $expenseDataFile;
        $this->loadData();
    }

    private function loadData()
    {
        $this->loadIncomeTransactions();
        $this->loadExpenseTransactions();
        $this->loadCategories();
    }

    private function loadCategories()
    {
        if (file_exists('data/categories.txt')) {
            $data = file_get_contents('data/categories.txt');
            $this->categories = unserialize($data);
        }
    }

    public function addIncomeTransaction(Transaction $transaction, Category $category)
    {
        $this->incomeTransactions[] = $transaction;
        $this->categories[] = $category;
        $this->saveIncomeTransactions();
        $this->saveCategories();
    }

    public function addExpenseTransaction(Transaction $transaction, Category $category)
    {
        $this->expenseTransactions[] = $transaction;
        $this->categories[] = $category;
        $this->saveExpenseTransactions();
        $this->saveCategories();
    }

    public function viewIncomeTransactions()
    {
        if (!empty($this->incomeTransactions)) {
            foreach ($this->incomeTransactions as $index => $transaction) {
                echo "Index: $index, Date: {$transaction->getDate()}, Category: {$transaction->getCategoryName()}, Amount: {$transaction->getAmount()}\n";
            }
        } else {
            echo "No income transactions to display.\n";
        }
    }

    public function viewExpenseTransactions()
    {
        if (!empty($this->expenseTransactions)) {
            foreach ($this->expenseTransactions as $index => $transaction) {
                echo "Index: $index, Date: {$transaction->getDate()}, Category: {$transaction->getCategoryName()}, Amount: {$transaction->getAmount()}\n";
            }
        } else {
            echo "No expense transactions to display.\n";
        }
    }

    public function viewCategories()
    {
        if (!empty($this->categories)) {
            echo "Income Categories:\n";
            $this->viewCategoryByType('income');
            
            echo "\nExpense Categories:\n";
            $this->viewCategoryByType('expense');
        } else {
            echo "No categories to display.\n";
        }
    }

    private function viewCategoryByType($type)
    {
        foreach ($this->categories as $category) {
            if ($category instanceof Category && $category->getType() === $type) {
                echo "{$category->getName()}\n";
            }
        }
    }

    public function viewTotalIncome()
    {
        if (!empty($this->incomeTransactions)) {
            $totalIncome = 0;
            foreach ($this->incomeTransactions as $transaction) {
                $totalIncome += $transaction->getAmount();
            }
            echo "Total Income: $totalIncome\n";
        } else {
            echo "No income transactions to calculate total.\n";
        }
    }

    public function viewTotalExpense()
    {
        if (!empty($this->expenseTransactions)) {
            $totalExpense = 0;
            foreach ($this->expenseTransactions as $transaction) {
                $totalExpense += $transaction->getAmount();
            }
            echo "Total Expense: $totalExpense\n";
        } else {
            echo "No expense transactions to calculate total.\n";
        }
    }

    public function viewNetTotal()
    {
        $totalIncome = 0;
        $totalExpense = 0;

        if (!empty($this->incomeTransactions)) {
            foreach ($this->incomeTransactions as $transaction) {
                $totalIncome += $transaction->getAmount();
            }
        }

        if (!empty($this->expenseTransactions)) {
            foreach ($this->expenseTransactions as $transaction) {
                $totalExpense += $transaction->getAmount();
            }
        }

        if (!empty($this->incomeTransactions) || !empty($this->expenseTransactions)) {
            $netTotal = $totalIncome - $totalExpense;
            echo "Net Total (Income - Expense): $netTotal\n";
        } else {
            echo "No transactions to calculate net total.\n";
        }
    }

    public function updateIncomeTransaction($index, $newAmount, Category $newCategory)
    {
        if (isset($this->incomeTransactions[$index])) {
            $this->incomeTransactions[$index]->setAmount($newAmount);
            $this->incomeTransactions[$index]->setCategory($newCategory);
            $this->saveIncomeTransactions();
            $this->saveCategories();
            echo "Income transaction updated successfully!\n";
        } else {
            echo "Invalid income transaction index.\n";
        }
    }

    public function updateExpenseTransaction($index, $newAmount, Category $newCategory)
    {
        if (isset($this->expenseTransactions[$index])) {
            $this->expenseTransactions[$index]->setAmount($newAmount);
            $this->expenseTransactions[$index]->setCategory($newCategory);
            $this->saveExpenseTransactions();
            $this->saveCategories();
            echo "Expense transaction updated successfully!\n";
        } else {
            echo "Invalid expense transaction index.\n";
        }
    }


    private function loadIncomeTransactions()
    {
        if (file_exists($this->incomeDataFile)) {
            $data = file_get_contents($this->incomeDataFile);
            $this->incomeTransactions = unserialize($data);
        }
    }

    private function saveIncomeTransactions()
    {
        file_put_contents($this->incomeDataFile, serialize($this->incomeTransactions));
    }

    private function loadExpenseTransactions()
    {
        if (file_exists($this->expenseDataFile)) {
            $data = file_get_contents($this->expenseDataFile);
            $this->expenseTransactions = unserialize($data);
        }
    }

    private function saveExpenseTransactions()
    {
        file_put_contents($this->expenseDataFile, serialize($this->expenseTransactions));
    }

    private function saveCategories()
    {
        file_put_contents('data/categories.txt', serialize($this->categories));
    }
}
