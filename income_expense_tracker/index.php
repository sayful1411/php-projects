<?php
require_once 'src/Category.php';
require_once 'src/Transaction.php';
require_once 'src/Tracker.php';

$tracker = new Tracker('data/incomes.txt', 'data/expenses.txt');

while (true) {
    echo "Income/Expense Tracker\n";
    echo "1. Add Income\n";
    echo "2. Add Expense\n";
    echo "3. View Incomes\n";
    echo "4. View Expenses\n";
    echo "5. View Categories\n";
    echo "6. View Total Income\n";
    echo "7. View Total Expense\n";
    echo "8. View Net Total\n";
    echo "9. Update Income Transaction\n";
    echo "10. Update Expense Transaction\n"; 
    echo "11. Exit\n";
    $choice = readline("Enter your choice: ");

    switch ($choice) {
        case '1':
            $incomeCategoryName = readline("Enter Income Category: ");
            $incomeCategory = new Category($incomeCategoryName, 'income');
            $amount = readline("Enter Amount: ");
            $date = date('Y-m-d H:i:s');
            $transaction = new Transaction($amount, $incomeCategory, $date);
            $tracker->addIncomeTransaction($transaction, $incomeCategory);
            echo "Income added successfully!\n";
            break;

        case '2':
            $expenseCategoryName = readline("Enter Expense Category: ");
            $expenseCategory = new Category($expenseCategoryName, 'expense');
            $amount = readline("Enter Amount: ");
            $date = date('Y-m-d H:i:s');
            $transaction = new Transaction($amount, $expenseCategory, $date);
            $tracker->addExpenseTransaction($transaction, $expenseCategory);
            echo "Expense added successfully!\n";
            break;

        case '3':
            echo "Income Transactions:\n";
            $tracker->viewIncomeTransactions();
            break;

        case '4':
            echo "Expense Transactions:\n";
            $tracker->viewExpenseTransactions();
            break;

        case '5':
            $tracker->viewCategories();
            break;

        case '6':
            $tracker->viewTotalIncome();
            break;

        case '7':
            $tracker->viewTotalExpense();
            break;

        case '8':
            $tracker->viewNetTotal();
            break;

        case '9':
            echo "Income Transactions:\n";
            $tracker->viewIncomeTransactions();
            $incomeIndex = readline("Enter the index number of the income transaction you want to update: ");
            $newAmount = readline("Enter the new amount: ");
            $incomeCategoryName = readline("Enter the new income category: ");
            $incomeCategory = new Category($incomeCategoryName, 'income');
            $tracker->updateIncomeTransaction($incomeIndex, $newAmount, $incomeCategory);
            break;

        case '10':
            echo "Expense Transactions:\n";
            $tracker->viewExpenseTransactions();
            $expenseIndex = readline("Enter the index number of the expense transaction you want to update: ");
            $newAmount = readline("Enter the new amount: ");
            $expenseCategoryName = readline("Enter the new expense category: ");
            $expenseCategory = new Category($expenseCategoryName, 'expense');
            $tracker->updateExpenseTransaction($expenseIndex, $newAmount, $expenseCategory);
            break;

        case '11':
            exit(0);

        default:
            echo "Invalid choice. Please try again.\n";
    }
}
