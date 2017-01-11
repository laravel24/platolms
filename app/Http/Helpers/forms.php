<?php

/*
|--------------------------------------------------------------------------
| Form Helpers
|--------------------------------------------------------------------------
*/

	/**
	 * Create a Basic Form Field
	 *
	 * @return string
	 */
	function makeBaseForm($formField, $name, $label, $errors)
	{
		$feedback = $errorClass = '';

		if ($errors->has($name))
		{
            $feedback = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            <span id="inputError2Status" class="sr-only">(error)</span>';
            $errorClass = 'has-error has-feedback';
		}

		return '
            <div class="form-group '.$errorClass.'">
		        <label class="control-label" for="'.$name.'">'.$label.'</label>
		        '.$formField.'
		        '.$feedback.'
		    </div>
		';
	}

	/**
	 * Create a Text Field
	 *
	 * @return string
	 */
	function makeTextField($name, $label, $default, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::text($name, $default, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}

	/**
	 * Create an Email Field
	 *
	 * @return string
	 */
	function makeEmailField($name, $label, $default, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::email($name, $default, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}

	/**
	 * Create a Select Field
	 *
	 * @return string
	 */
	function makeSelectField($name, $options, $label, $default, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::select($name, $options, $default, [''.$required.'', 'class' => ''.$class.' form-control']);			

		if ($placeholder)
		{
			$formField = Form::select($name, $options, $default, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		}

		return makeBaseForm($formField, $name, $label, $errors);
	}

	/**
	 * Create a Text Area Field
	 *
	 * @return string
	 */
	function makeTextAreaField($name, $label, $default, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::textarea($name, $default, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}

	/**
	 * Create a Password Field
	 *
	 * @return string
	 */
	function makePasswordField($name, $label, $default, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::password($name, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}

	/**
	 * Create an Number Input Field
	 *
	 * @return string
	 */
	function makeNumberInputField($name, $label, $default, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::number($name, $default, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}				

	/**
	 * Create an Date Input Field
	 *
	 * @return string
	 */
	function makeDateInputField($name, $label, $default, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::date($name, $default, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}	

	/**
	 * Create a Radio Field
	 *
	 * @return string
	 */
	function makeCheckBoxField($name, $label, $value, $checked, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::checkbox($name, $value, $checked, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}	

	/**
	 * Create a Radio Field
	 *
	 * @return string
	 */
	function makeRadioField($name, $label, $value, $checked, $placeholder, $required, $errors, $class = '')
	{
		$formField = Form::radio($name, $value, $checked, [''.$required.'', 'placeholder' => ''.$placeholder.'', 'class' => ''.$class.' form-control']);
		return makeBaseForm($formField, $name, $label, $errors);
	}				
