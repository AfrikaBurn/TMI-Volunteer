@extends('app')

@section('content')
    <h1>Create a Department for: {{ $event->name }}</h1>
    <hr>
    
    {!! Form::open(['url' => '/department']) !!}
        <input type="hidden" name="event" value="{{ $event->id }}">
        
        @include('partials/form/input', ['name' => 'name', 'label' => 'Department Name', 'placeholder' => "General department name"])
        @include('partials/form/textarea', ['name' => 'description', 'label' => 'Description', 'placeholder' => 'A brief description of this department'])
        @include('partials/roles');

        <button type="submit" class="btn btn-primary">Submit</button>
    {!! Form::close() !!}
@endsection
