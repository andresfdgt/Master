@extends('errors::minimal')

@section('title', __('No encontramos lo que buscabas'))
@section('image')
<img style="width: 34%" src="{{ asset('images/404.svg') }}" alt="">
@endsection
@section('message', __('No encontramos lo que buscabas'))