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
             "classError" => "hasError", // specific error class
        ],
        "defaultLabel" => [
            "class" => '',
            "noError" => false,
            "classError" => "hasError",
            "errorFormat" => "%MSG%", // Error message format (%MSG% will be replaced by the error message)
        ],
	])
	->text("fieldname", "value", $options)
	->text("name", isset($user->name) ? $user->name : '', [
		"noError" => true // don't manage error for this input
		"label" => "Enter your name"
		"class" => "name_input"
	])
	->text("login", isset($user->login) ? $user->login : '', [
		"label" => [
			"title" => "Enter your login"
			"classError" => "your_specific_error_class_for_this_label"
		]
		"class" => "name_input"
	])
	->start_fieldset([
		"class" => "whatever you want"
		"lgend" => "My fieldset" // of course it's optional !
	])
	->textarea("fieldname", "content", $options)
	->password("fieldname", "value", $options)
	// $select-options an array like ["id" => "valeur"] or an object
	// if it's an object you must provide an option "value" and an optional option "key"
	// ex: $user = {id : 1, name: "Joe"}
	// $options[
	//     "key" => 'id' // default to id
	//     "value" => 'name'
	// ]
	->select("fieldname", $select-options, $options)
	->close_fieldset()
	->end("Send", $senbSubmitOptions)
```

### TODO
add other input type like date, checkbox...