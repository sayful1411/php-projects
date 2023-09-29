<?php 

namespace App\Main;

use App\Admin\AdminDashboard;
use App\Admin\Admin;
use App\Main\CustomerDashboard;

class Customer{
    protected array $customerInfo = [];
    protected Storage $storage;
    protected float $balance;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->balance = 0.0;
    }

    public static function getModelName(): string
    {
        return 'customer';
    }

    public function register(string $name, string $email, int $password)
    {
        // Load existing customer data
        $existingCustomers = $this->storage->load(Customer::getModelName());

        // Check if the email already exists
        foreach ($existingCustomers as $customer) {
            if ($customer['email'] === $email) {
                echo "Email already exists. Registration declined.\n";
                return; // Exit the registration process
            }
        }

        // Add the new customer to the array
        $info = [
            'name' => $name, 
            'email' => $email, 
            'password' => $password,
            'balance' => $this->balance,
        ];
        $this->customerInfo[] = $info;

        // Save customer data
        $this->saveCustomer();

        printf("Customer registration successfully!\n");

    }

    public function login(string $email, int $password)
    {
        // Load existing customer and admin data
        $existingCustomers = $this->storage->load(Customer::getModelName());
        $existingAdmins = $this->storage->load(Admin::getModelName());

        // Check if it's an admin login
        foreach ($existingAdmins as $admin) {
            if ($admin['email'] === $email && $admin['password'] === $password) {
                echo "Welcome to admin dashboard!\n";
                $adminDashboard = new AdminDashboard($this->storage, $admin);
                $adminDashboard->run();
                return;  // Exit the login process
            }
        }

        // Assume no matching customer is found initially
        $matchingCustomer = null;

        foreach ($existingCustomers as $customer) {
            if ($customer['email'] === $email && $customer['password'] === $password) {
                $matchingCustomer = $customer;
                break;  // Exit the loop once a matching customer is found
            }
        }

        // Check if it's a customer
        if ($matchingCustomer !== null) {
            echo "Welcome to customer dashboard!\n";
            $dashboard = new CustomerDashboard($this->storage, $matchingCustomer);
            $dashboard->run();
        } else {
            echo "Incorrect login credentials.\n";
        }

    }

    protected function saveCustomer(): void
    {
        $this->storage->save(Customer::getModelName(), $this->customerInfo);
    }


}