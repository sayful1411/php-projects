<?php 

namespace App\Admin;

use App\Main\BankCLIApp;
use App\Main\Storage;

class Admin extends BankCLIApp{

    protected array $adminInfo = [];
    protected Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public static function getModelName(): string
    {
        return 'admin';
    }
    
    public function run()
    {
        // Load existing admin data
        $existingAdmin = $this->storage->load(Admin::getModelName());

        $email = trim(readline("Enter your email: "));
        $password = (int)trim(readline("Enter your password: "));

        // Check if the email already exists
        foreach ($existingAdmin as $admin) {
            if ($admin['email'] === $email) {
                echo "Email already exists.\n";
                return; // Exit the registration process
            }
        }

        // Add the new customer to the array
        $info = [
            'email' => $email, 
            'password' => $password,
        ];
        $this->adminInfo[] = $info;

        // Save admin data
        $this->saveAdmin();

        printf("Admin created successfully!\n");

    }

    private function saveAdmin(): void
    {
        $this->storage->save(Admin::getModelName(), $this->adminInfo);
    }

}