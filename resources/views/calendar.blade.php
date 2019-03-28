@extends('layouts.app')
@section('title', 'Tasks calendar')

@section('content')
    <tasks-calendar :tasks="{{ $tasks }}"></tasks-calendar>
@endsection
