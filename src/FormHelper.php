<?php


namespace Swith;


class FormHelper extends FormConstructor
{

    /**
     * Start form tag
     * @param string $action
     * @param string $method
     * @param array $options
     * @return string
     */
    public function start($action = "#", $method = "POST", $options = [])
    {
        $this->options = array_merge($this->defaultOptions, $options);

        $outputOptions = "";
        if ($options != null) {
            $outputOptions = self::setOptions($options, [
                "errors",
                "manageErrors",
                "errorClass",
                "showErrorMessage",
                "defaultLabel",
                "defaultInput"
            ]);
        }

        $this->openTag = "<form action='$action' method='$method' $outputOptions>";

        return $this;
    }

    /**
     * Close form tag
     * @param string $value
     * @param array|null $options
     * @return string
     */
    public function end($value = "Send", array $options = null)
    {
        $outputOptions = "";
        if ($options != null) {
            $outputOptions = self::setOptions($options);
        }

        $this->closeTag =  "<input type='submit' value='$value' $outputOptions></form>";

        return $this->getOutput();
    }

    /**
     * Generate an input tag with his label and display error
     * @param string $type
     * @param string $field
     * @param string $value
     * @param array $options
     * @return $this
     */
    public function input($type = "text", $field, $value = "", $options = [])
    {
        $options = array_merge($this->options["defaultInput"], $options);
        $outputOptions = "";
        if ($options != null) {
            $outputOptions = $this->setOptions($options, ['id', 'label', 'noError', 'value', 'errorFormat', 'classError'], $field);
        }

        $this->field = $field;

        if ($this->options['manageErrors'] && (isset($options['noError']) && !$options['noError'] || !isset($options['noError']))) {
            if ($this->inputHasError($field)) {
                if (!isset($this->inputs[$field]['options']['class'])) {
                    $this->inputs[$field]['options']['class'] = "";
                }
                $this->inputs[$field]['options']['class'] .= ' ' . $this->getClassError($options);
            }
        }

        if ($type === "password") {
            $value = "";
        }

        if (isset($options['label'])) {
            $this->inputs[$field]['label'] = $this->setupLabel($options['label']);
        }

        if ($outputOptions === "") {
        	$outputOptions = $this->getAllOptions($field);
        }

        $this->inputs[$field]['tag'] = "<input type='$type' name='$field' id='$field' value='$value' $outputOptions>";
        return $this;
    }

    /**
     * @param $field
     * @param string $value
     * @param array $options
     * @return $this
     */
    public function text($field, $value = "", $options = [])
    {
        $this->input("text", $field, $value, $options);

        return $this;
    }

    /**
     * @param $field
     * @param string $value
     * @param array $options
     * @return $this
     */
    public function password($field, $value = "", $options = [])
    {
        $this->input("password", $field, $value, $options);

        return $this;
    }

    /**
     * @param $field
     * @param string $value
     * @param array $options
     * @return $this
     */
    public function textarea($field, $value= "", $options = [])
    {
        $options = array_merge($this->options["defaultInput"], $options);
        $outputOptions = "";
        if ($options != null) {
            $outputOptions = $this->setOptions($options, ['id', 'label', 'noError', 'value', 'errorFormat', 'classError'], $field);
        }

        $this->field = $field;

        if ($this->options['manageErrors'] && (isset($options['noError']) && !$options['noError'] || !isset($options['noError']))) {
            if ($this->inputHasError($field)) {
                if (!isset($this->inputs[$field]['options']['class'])) {
                    $this->inputs[$field]['options']['class'] = "";
                }
                $this->inputs[$field]['options']['class'] .= ' ' . $this->getClassError($options);
            }
        }

        if (isset($options['label'])) {
            $this->inputs[$field]['label'] = $this->setupLabel($options['label']);
        }

        if ($outputOptions === "") {
            $outputOptions = $this->getAllOptions($field);
        }

        $this->inputs[$field]['tag'] = "<textarea name='$field' id='$field' $outputOptions>$value</textarea>";
        return $this;
    }

    /**
     * @param $field
     * @param array $selectOptions
     * @param array $options
     * @return $this
     */
    public function select($field, $selectOptions = [], $options = [])
    {
        $options = array_merge($this->options["defaultInput"], $options);
        $outputOptions = "";
        if ($options != null) {
            $outputOptions = $this->setOptions($options, ['id', 'label', 'noError', 'value', 'errorFormat', 'classError'], $field);
        }

        $this->field = $field;

        if ($this->options['manageErrors'] && (isset($options['noError']) && !$options['noError'] || !isset($options['noError']))) {
            if ($this->inputHasError($field)) {
                if (!isset($this->inputs[$field]['options']['class'])) {
                    $this->inputs[$field]['options']['class'] = "";
                }
                $this->inputs[$field]['options']['class'] .= ' ' . $this->getClassError($options);
            }
        }

        if (isset($options['label'])) {
            $this->inputs[$field]['label'] = $this->setupLabel($options['label']);
        }

        if ($outputOptions === "") {
            $outputOptions = $this->getAllOptions($field);
        }

        $outputselectoptions = "";
        foreach ($selectOptions as $k => $v) {
            if (isset($options['selected']) && $v == $options['selected']) {
                $slctd = "selected='selected'";
            } else {
                $slctd = "";
            }
            $outputselectoptions .= "<option $slctd value='$v'>$k</option>";
        }

        $this->inputs[$field]['tag'] = "<select name='$field' id='$field' $outputOptions>$outputselectoptions</select>";

        return $this;
    }

    public function start_fieldset($options = [])
    {
        $outputOptions = $this->setOptions($options, ['noError', 'value', 'errorFormat', 'classError', 'legend'], $this->currentFieldset);

        $legend = "";
        if (isset($options['legend'])) {
        	$legend = "<legend>" . $options['legend'] . "</legend>";
        }
        $this->inputs['f_' . $this->currentFieldset]['tag'] = "<fieldset $outputOptions>$legend";
        return $this;
    }

    public function close_fieldset()
    {

        $this->inputs['fe_' . $this->currentFieldset]['tag'] = "</fieldset>";
        $this->currentFieldset++;

        return $this;
    }
}