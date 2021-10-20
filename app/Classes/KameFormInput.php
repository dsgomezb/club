<?php

namespace App\Classes;

use Illuminate\Support\HtmlString;

class KameFormInput extends HtmlString
{
    private $tpl = '
        <div class="mb-3 col-md-12" ${wrapper}>
            <label class="form-label" for="${for}">${label}</label>
            ${input}
            <div class="invalid-feedback"></div>
            ${help}
        </div>
    ';

    private $name;

    private $extraData = '';

    public function __construct($html, $name)
    {
        $this->html = str_replace('${input}', $html, $this->tpl);

        $this->name = $name;
    }

    public function wrapper($options)
    {
        //if (!isset($options['class'])) $options['class'] .= ' mb-3 col-md-12';

        $options['class'] = isset($options['class']) ? $options['class'] . ' mb-3 col-md-12' : ' mb-3 col-md-12';
        $options = str_replace("=", '="', http_build_query($options, null, '" ', PHP_QUERY_RFC3986)).'"';
        $options = str_replace('%20', ' ', $options);
        $options = str_replace('%3A', ':', $options);
        $this->html = str_replace('${wrapper}', $options, $this->html);

        return $this;
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