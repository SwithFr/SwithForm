# Swith Form
Simple helper base on [Swith framework](https://github.com/SwithFr/swithMVC).

## How to install ?
`composer require swith/form:dev-master`

## How to use ?
```php
require "vendor/autoload.php";

use Swith\Form;

<?=
	Form::start("url_for_action_attribute", "POST", [
		// Here you can configure default options
		"manageErrors" => true, // display error message ?
        "errors" => null, // Array like [ "fieldname" => "error message" ]
        "errorClass" => "hasError", // Default class error
        "showErrorMessage" => true, // show error message in label ?
        "defaultInput" => [
            "class" => '',
            "noError" => false, // manage error for input ?
             "errorClass" => "hasError", // specific error class
        ],
        "defaultLabel" => [
            "class" => '',
            "noError" => false,
            "errorClass" => "hasError",
            "errorFormat" => "%MSG%", // Error message format (%MSG% will be replaced by the error message)
        ],
	])
	->text()
	->textarear()
	->password()
	->select()
	->end()
?>
```