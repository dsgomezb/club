<?php

namespace App\Classes;

use Illuminate\Support\HtmlString;

class KameFormCheckboxes extends HtmlString
{
    private $tpl = '
        <div class="mb-3 col-md-12">
            <h5 class="frame-heading">${label}</h5>
            ${options}
            <div class="invalid-feedback"></div>
            ${help}
        </div>
    ';

    private $optionTpl = '
        <div class="custom-control custom-checkbox custom-control-inline">
            ${input}
            <label class="custom-control-label" for="${optionId}">${optionLabel}</label>
        </div>
    ';

    private $name;

    private $extraData = '';

    public function __construct($name, $options)
    {
        $tpl = '';

        foreach ($options as $key => $value) {
            $tpl .= $this->optionTpl;
            $input = \Form::checkbox($name.'[]', $key, null , ['id' => \Str::slug($name.'-'.$value), 'class' => 'custom-control-input']);
            $tpl = str_replace('${input}', $input, $tpl);
            $tpl = str_replace('${optionLabel}', $value, $tpl);
            $tpl = str_replace('${optionId}', \Str::slug($name.'-'.$value), $tpl);
        }

        $this->html = str_replace('${options}', $tpl, $this->tpl);
        $this->name = $name;
    }

    public function help($text='')
    {
        $tpl = '<div class="help-block">${text}</div>';

        $this->html = str_replace('${help}', $tpl, $this->html);
        $this->html = str_replace('${text}', $text, $this->html);

        return $this;
    }

    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    public function col($sizes='')
    {
        $sizes = 'col-' . str_replace(' ', ' col-', $sizes);

        $this->html = str_replace('col-md-12', $sizes, $this->html);

        return $this;
    }

    public function bind($name)
    {
        $this->extraData .= 'data-bind="'. $name .'"';

        return $this;
    }

    public function toHtml()
    {
        $this->parse();

        return preg_replace('/\$\{[a-zA-Z0-9_-]+\}/', '', $this->html);
    }

    private function parse()
    {
        $id = $this->id ?? $this->name;
        $label = $this->label ?? \Str::title(__('kameform.' . $this->name));

        $replace = (strstr($this->html, 'form-control') !== false) ? '<$1 $2 ${data} id="'.$id.'">' : '<$1 $2 ${data} class="form-control" id="'.$id.'">';

        $this->html = preg_replace('/<(input|select|textarea)(\b[^><]*)>/i', $replace, $this->html);
        $this->html = str_replace('${for}', $id, $this->html);
        $this->html = str_replace('${label}', $label, $this->html);

        if ($this->extraData) {
            $this->html = str_replace('${data}', $this->extraData, $this->html);
        }
    }
}