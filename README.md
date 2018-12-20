# CLI to validate UK phone numbers

### This is a simple CLI tool to validate U.K. numbers, get the carrier of each number and create a CSV file with the result

### Requirements

-   PHP 7+
-   Composer

### How to set up the project?

1. Clone this repository
2. Install the dependencies running `composer install` in the console

### How to run the CLI tool?

`./console.php validate ./files/numbers.txt ./files/validNumbers.csv`

Where the first file is the list of numbers to validate and the second one is the file with the results of the validation, the list of UK numbers is comming from this [page](https://fakenumber.org/generator/mobile)

### What about the carrier?

The _"lookup"_ services to get the carrier of any phone number have a cost, that's the reason I've implemented a fake function to return always the same carrier

### When a number is valid?

This tool validates the format of the numbers using a pattern that checks the country code and also the phone number format
