<?php

namespace App\Classes;

class Calendar
{
    public $days = ['', 'Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'];
    public $months = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];


    public function numberToDay($i)
    {
        return $this->days[$i];
    }

    public function numberToWeek($i)
    {
        return "Semana $i";
    }

    public function numberToMonth($i)
    {
        return $this->months[$i];
    }
}