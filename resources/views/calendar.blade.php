@extends('layouts.app')

@section('content')
    <tasks-calendar :tasks="{{ $tasks }}"></tasks-calendar>
@endsection
