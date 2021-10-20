<?php

namespace App\Classes;

class KameForm
{
    public function open($options = []){
        return \Form::open($options);
    }

    public function model($model, $options)
    {
        return \Form::model($model, $options);
    }

    public function text($name, $options = [], $customValue = null)
    {
        return $this->input(\Form::text($name, $customValue, $options), $name);
    }

    public function textarea($name, $options = [])
    {
        return $this->input(\Form::textarea($name, null, $options), $name);
    }

    public function select($name, $values=[], $options = [])
    {
        $options['class'] = (isset($options['class'])) ? $options['class'] . '  form-control' : 'custom-select form-control';

        //$options = array_merge($options, ['class' => 'custom-select form-control']);

        return $this->input(\Form::select($name, $values, null, $options), $name);
    }

    public function editable($name, $options = [])
    {
        $options = array_merge($options, ['class' => 'wysiwyg form-control']);

        return $this->input(\Form::textarea($name, null, $options), $name);
    }

    public function datepicker($name, $options = [])
    {
        $options = array_merge($options, ['class' => 'datepicker form-control']);

        return $this->input(\Form::text($name, null, $options), $name);
    }

    public function submit($name, $options=[])
    {
        return '
            <div class="col-md-12">
                <button type="submit" class="float-right btn btn-success waves-effect waves-themed">Guardar</button>
            </div>
        ';
    }

    public function close()
    {
        return \Form::close();
    }

    private function input($input, $name)
    {
        return new KameFormInput($input, $name);
    }

    public function checbox($name, $options)
    {
        return new KameFormCheckboxes($name, $options);
    }
}