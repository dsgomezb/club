@extends('admin.layouts.app')

@section('section', 'Categorías')

@section('icon', 'tags')

@section('widget-body')
    {!! KameForm::model($model, $formOptions) !!}

        {!! KameForm::text('value') !!}

        {!! KameForm::submit('Enviar') !!}

    {!! KameForm::close() !!}
@endsection
