# PHP Developer Coding Exemplar Solution

## Question 1
strpos() returns false if the search string is not found. However, it returns the string's position if found, 
0 (boolean false) in such a case where it is the fist word. 

A solution would be to check for identical matches using === as below:
```php
<?php
if(strpos($str, 'superman') === false)
    throw new Exception;
```

## Question 2
With the many number of records in the table (as indicated in the rows column, 10320), the query needed optimized for performance by indexing. 
This has not be done since relevant indexes could not be found (possible_keys and key columns are NULL).

## Question 3

Using bcrypt is the current accepted password hashing best practice.

The password_verify() function takes the password supplied and the hashed string as arguments 
and returns true if the hash matches the specified password.

````
<?php
if (password_verify($password, $hash)) {
    // Passwords Match!
}else {
    // Invalid credentials
}
````
The password_compat library is one of the libraries that can be used in earlier versions of php to emulate bcrypt

## Question 4
````
<?php
function searchArray($item, $array){
    if (in_array($item, $array))
        return true;
        
    return false;    
}
````
The searchArray() function above uses the inbuilt in_array() php function which searches an array for a specific value
and returns true if it is found

## Question 5
Turning off query buffering will most likely help manage rogue memory consumption.

```php
$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

$stmt = $pdo->prepare('SELECT * FROM largeTable');
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
	// manipulate the data here
}
```

## Question 6
Function that takes a phone number in any form and formats it to 3-3-4 US block standard using a delimiter supplied. 

````php

function formatPhoneNumber($phone_number,$delimiter = '-'){
    #remove anything that is not a number
    $phone_number = preg_replace("/[^\d]/","",$phone_number);

    # get phone number length check that it is valid (10)
    if (strlen($phone_number) !== 10)
        return false;

    #formart valid phone numbers using the dlimeter provided
    $phone_number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1".$delimiter."$2".$delimiter."$3", $phone_number);

    #return the formatted phone number
    return $phone_number;
}

````

## Question 7
Design 'skeleton' for a library to store and retrieve data from the cache (Memcached and APC)

````
<?php 

class CacheWorker
{
    public $envionment;

    function __construct($environment)
    {
        $this->environment = $environment;
    }

    #Store data to cache.
    function store($key,$value,$expiry = 1800)
    {
        switch($this->environment)
        {
            case 'apc':
                #use APC to cache
                apc_add($key, $value , $expiry);
                break;
            default:
                #use memcached to store
                $memcache = new Memcache;
                $memcache->set($key, $value, false, $expiry);
                break;
        }
    }

    #Retrieve data from cache.
    function retrieve($key)
    {
        switch($this->environment)
        {
            case 'apc':
                #retrieve from APC
                return apc_fetch($key);
                break;
            default:
                #retrieve from memcahed
                $memcache = new Memcache;
                return $memcache->get($key);
                break;
        }
    }
}

?>

````

## Question 8
Set of unit tests for the fizzBuzz($start = 1, $stop = 100) function

```php

class FizzBuzzTest extends TestCase
{
    /**
     * Valid Input
     *
     */
    public function testValidInput()
    {
        $this->assertContains('Fizz',fizzBuzz());
    }

    /**
     * start < 0
     *
     */
    public function testStartLessThanZero()
    {
         $this->assertContains('Fizz',fizzBuzz(0));

    }

    /**
     * stop > 100
     *
     */
    public function testStopGreaterThanHundred()
    {
         $this->assertContains('Fizz',fizzBuzz(1,120));

    }

    /**
     * start = stop
     *
     */
    public function testStartEqualsStop()
    {
         $this->assertContains('Fizz',fizzBuzz(23,23));

    }

    /**
     * non-numeric input
     *
     */
    public function testNonNumericInput()
    {
         $this->assertContains('Fizz',fizzBuzz('ping','pong'));
    }
}


```

## Question 9
Solution to Catchable fatal error: Object of class Select could not be converted to string

:Use a different class name

## Question 10
Method for applying the exclusion list against the file list WITHOUT nested foreach() loops.

```php

function remove_excluded_files($files,$exclude)
{
    $excluded = array_diff($files,$exclude);

    foreach ($exclude as $item)
    {
    
        $path = explode('.',$item);

        if (count($path) < 2)
        {
            $path = $path[0];

            $result = array_filter($files, function ($item) use ($path) {
                
                if (stripos($item, $path) !== false)
                {
                    return true;
                }
                
                return false;
            });

            $file = array_values($result);
            $excluded = array_diff($excluded,$file);
        }
        
    }

    return $excluded;
}

```
