<?php


namespace Swith;


class FormConstructor
{

    public $field;
    protected $defaultOptions = [
        "manageErrors" => true,
        "errorClass" => "hasError",
        "showErrorMessage" => true,
        "defaultInput" => [
            "class" => '',
            "noError" => false,
            "classError" => "hasError",
        ],
        "defaultLabel" => [
            "class" => '',
            "noError" => false,
            "classError" => "hasError",
            "errorFormat" => "%MSG%",
        ],
        "errors" => null,
    ];

    public $options = [];

    public $openTag;
    public $closeTag;
    public $inputs = [];

    public $errors = [];

    public $currentFieldset = 0;

    /**
     * Set options for a form or an input element
     * @param array $options
     * @param array $skip Some options to skip
     * @param null $field
     * @return string
     */
    protected function setOptions($options = [], $skip = [], $field = null)
    {
        $outputOptions = "";
        foreach ($options as $optionName => $optionValue) {
            if ($skip) {
                if (!is_array($optionValue) && !in_array($optionName, $skip)) {
                    if ($field) {
                        $this->inputs[$field]['options'][$optionName] = $optionValue;
                    } else {
                        $outputOptions .= "$optionName='$optionValue' ";
                    }
                }
            } elseif ($field) {
                $this->inputs[$field]['options'][$optionName] = $optionValue;
            } else {
                $outputOptions .= "$optionName='$optionValue' ";
            }
        }
        return $outputOptions;
    }

    /**
     * Setup the label for an element if requested
     * @param $labelOptions
     * @return string
     */
    protected function setupLabel($labelOptions)
    {
        $options = [];
        if (is_array($labelOptions)) {
            $options = array_merge($this->options['defaultLabel'], $labelOptions);
        } else {
            $options = array_merge($this->options['defaultLabel'], ['title' => $labelOptions]);
        }

        $title = $this->getTitle($labelOptions);

        if ($this->options['manageErrors'] && (isset($labelOptions['noError']) && !$labelOptions['noError'] || !isset($labelOptions['noError']))) {
            if ($this->inputHasError($this->field)) {
                @$options['class'] .= ' ' . $this->getClassError($options);

                if ($this->options['showErrorMessage']) {
                	$title .= ' ' . $this->formatErrorMessage($options);
                }
            }
        }

        $outputOptions = $this->setOptions($options, ['for', 'label', 'noError', 'noError', 'errorClass', 'errorFormat', 'title']);

        $outputLabel = "<label for='{$this->field}' $outputOptions>$title</label>";
        return $outputLabel;
    }

    /**
     * Gnerate the html code for the form
     * @return string
     */
    protected function getOutput()
    {
        return $this->openTag . $this->getAllInputs() . $this->closeTag;
    }

    /**
     * Check if the input has an error
     * @param $field
     * @return bool
     */
    protected function inputHasError($field)
    {
        return isset($this->options['errors']) && isset($this->options['errors'][$field]);
    }

    /**
     * Get all options (attributes) for an input
     * @param $field
     * @return string
     */
    protected function getAllOptions($field)
    {
        $outputOptions = "";
        if (isset($this->inputs[$field]['options'])) {
            foreach ($this->inputs[$field]['options'] as $optionName => $optionValue) {
                $outputOptions .= "$optionName='$optionValue' ";
        	}
        }

        return $outputOptions;
    }

    /**
     * Get the HTML code for an element and his label
     * @return string
     */
    private function getAllInputs()
    {
        $inputs = "";
        foreach ($this->inputs as $input) {
            $inputs .= isset($input['label']) ? $input['label']. $input['tag'] : $input['tag'];
        }

        return $inputs;
    }

    /**
     * Get a value for a key in the options array
     * @param $key
     * @param $options
     * @return string
     */
    private function get($key, $options)
    {
        return isset($options[$key]) ?  $options[$key] : '';
    }

    /**
     * Shortcut to get the class attribute
     * @param $options
     * @return string
     */
    private function getClass(array $options)
    {
        return $this->get('class', $options) . ' ' . $this->options['defaultLabel']['class'];
    }

    /**
     * shortcute to get the Label title
     * @param array|string $options
     * @return string
     */
    private function getTitle($options)
    {
        if (!is_array($options)) {
        	return $options;
        }

        return $this->get('title', $options);
    }

    /**
     * Get the class error for label or input (the defautl one or the specified class)
     * @param array $options
     * @return mixed
     */
    protected function getClassError(array $options)
    {
        return isset($options['classError']) ? $options['classError'] : $this->options['errorClass'];
    }

    private function formatErrorMessage(array $options)
    {
        $msg = $this->options['errors'][$this->field];
        return str_replace('%MSG%', $msg, $options['errorFormat']);
    }
}