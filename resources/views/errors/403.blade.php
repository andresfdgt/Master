@extends('errors::minimal')

@section('title', __('No estás autorizado'))
@section('image')
<img style="width: 34%" src="{{ asset('images/403.svg') }}" alt="">
@endsection
@section('message', __('No estás autorizado'))