<?php 

namespace App\Main;

class BankCLIApp{

    private Customer $customer; // composition

    protected const LOGIN = 1;
    protected const REGISTER = 2;

    protected array $options = [
        self::LOGIN => 'Login',
        self::REGISTER => 'Register',
    ];

    public function __construct() {
        $this->customer = new Customer(new CustomerStorage);
    }

    public function run()
    {
        while(true){
            foreach ($this->options as $option => $label) {
                printf("%d. %s\n", $option, $label);
            }

            $choice = intval(readline("Enter your choice: "));

            switch($choice){
                case self::LOGIN:
                    $email = trim(readline("Enter your email: "));
                    $password = (int)trim(readline("Enter your password: "));
                    $this->customer->login($email,$password);
                    break;

                case self::REGISTER:
                    $name = trim(readline("Enter your name: "));
                    $email = trim(readline("Enter your email: "));
                    $password = (int)trim(readline("Enter your password: "));
                    $this->customer->register($name, $email, $password);
                    break;
                    
                default:
                    echo "Invalid option.\n";
            }
        }
    }
}