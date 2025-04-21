<?php

/**
 * User: Divya Shrestha <work@divyashrestha.com.np>
 * Date: 21/04/2025
 * Time: 21:17
 */

namespace divyashrestha\mvc\form;


/**
 * Class TextareaField
 *
 * @author  Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\mvc\form
 */
class TextareaField extends BaseField
{
    public function renderInput()
    {
        return sprintf('<textarea class="form-control%s" name="%s">%s</textarea>',
             $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }
}