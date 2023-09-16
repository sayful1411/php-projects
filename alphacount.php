#!/usr/bin/env php
<?php
// Check if the script is run without any arguments
if ($argc === 1) {
    // Prompt the user for input
    $sentence = readline("Enter a sentence: ");
} elseif ($argc === 2) {
    // Use the provided argument as the sentence
    $sentence = $argv[1];
} else {
    // Incorrect number of arguments provided
    echo "Usage: php alphacount.php [<sentence>]\n";
    exit(1);
}

// Remove non-alphabet characters and count the remaining characters
$alphabetCount = preg_match_all('/[a-zA-Z]/', $sentence, $matches);

// Display the result
echo "Alphabet count: $alphabetCount\n";

// Usage:
// 1. to execute script run 
// ./alphacount.php 
// or
// ./alphacount.php "sentence"
