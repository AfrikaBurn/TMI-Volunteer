<?php

// Generate list of available shifts by department
$shifts = [];

foreach($schedule->event->departments as $department)
{
    $shifts[$department->id] = [];

    foreach($department->shifts as $shift)
    {
        $shifts[$department->id][] =
        [
            'id' => $shift->id,
            'name' => $shift->name
        ];
    }
}

// Generate array of event days to be displayed as checkboxes
$days = [];

foreach($schedule->event->days() as $day)
{
    $days[$day->date->format('Y-m-d')] = $day->name . " (" . $day->date->format('Y-m-d') . ")";
}

?>

@extends('app')

@section('content')

    <div class="header-buttons pull-right">
        @can('delete-schedule')
            <a href="/schedule/{{ $schedule->id }}/delete" class="btn btn-danger">Delete from the Shedule</a>
        @endcan
    </div>

    <h1>Editing schedule for: {{ $schedule->department->name }}</h1>
    <hr>

    {{-- Output available shifts as JSON so the shift dropdown can be dynamically populated --}}
    <textarea class="hidden available-shifts">{{ json_encode($shifts) }}</textarea>

    {!! Form::open() !!}

        @if($schedule->event->departments->count())
            <div class="form-group {{ ($errors->has('department_id')) ? 'has-error' : '' }}">
                <label class="control-label" for="department-field">Department</label>

                <select name="department_id" class="form-control department-dropdown" id="department-field">
                    <option value="">Select a department</option>

                    @foreach($schedule->event->departments as $department)
                        <option value="{{ $department->id }}" {{ $schedule->department->id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>

                @if($errors->has('department_id'))
                    <span class="help-block">{{ $errors->first('department_id') }}</span>
                @endif
            </div>
        @else
            <div class="alert alert-danger">
                <b>Oops!</b> A department has to be created before you can make a shift.

                @can('create-department')
                    <a href="/event/{{ $schedule->event->id }}/department/create">Click here</a> to create your first department.
                @endcan
            </div>
        @endif

        <div class="form-group {{ ($errors->has('shift_data_id')) ? 'has-error' : '' }}">
            <label class="control-label" for="shift-field">Shift</label>

            <select name="shift_data_id" class="form-control shift-dropdown" id="shift-field" data-saved="{{ $schedule->shift_data_id }}">
                <option value="">Select a shift</option>
                <option value="" class="dynamic">This list will be automatically updated after selecting a department</option>
            </select>

            @if($errors->has('shift_data_id'))
                <span class="help-block">{{ $errors->first('shift_data_id') }}</span>
            @endif
        </div>

        @include('partials/form/checkbox', ['name' => 'dates', 'label' => 'Event Dates', 'options' => $days, 'selected' => json_decode($schedule->dates)])

        <div class="custom-wrap">
            @include('partials/form/select',
            [
                'name' => 'start_time',
                'label' => 'Start Time',
                'help' => "The time of day when the first shift starts",
                'options' =>
                [
                    '' => 'Select a time',
                    '0:00' => 'Midnight (beginning of day)',
                    '6:00' => '6 AM',
                    '9:00' => '9 AM',
                    '12:00' => 'Noon',
                    'custom' => 'Other'
                ],
                'value' => $schedule->start_time
            ])

            <div class="custom hidden">
                @include('partials/form/time', ['name' => 'custom_start_time', 'label' => 'Custom Start Time', 'value' => $schedule->start_time])
            </div>
        </div>

        <div class="custom-wrap">
            @include('partials/form/select',
            [
                'name' => 'end_time',
                'label' => 'End Time',
                'help' => "The time of day when the last shift ends",
                'options' =>
                [
                    '' => 'Select a time',
                    '12:00' => 'Noon',
                    '18:00' => '6 PM',
                    '21:00' => '9 PM',
                    '24:00' => 'Midnight (end of day)',
                    'custom' => 'Other'
                ],
                'value' => $schedule->end_time
            ])

            <div class="custom hidden">
                @include('partials/form/time', ['name' => 'custom_end_time', 'label' => 'Custom End Time', 'value' => $schedule->end_time])
            </div>
        </div>

        <div class="custom-wrap">
            @include('partials/form/select',
            [
                'name' => 'duration',
                'label' => 'Duration',
                'help' => "The duration of each slot in this shift",
                'options' =>
                [
                    '' => 'Select a duration',
                    '3:00' => 'Regular Shift (3 hours)',
                    '6:00' => 'Shift Lead (6 hours)',
                    'custom' => 'Other'
                ],
                'value' => $schedule->duration
            ])

            <div class="custom hidden">
                @include('partials/form/time', ['name' => 'custom_duration', 'label' => 'Custom Duration', 'value' => $schedule->duration])
            </div>
        </div>

        @include('partials/form/text', ['name' => 'volunteers', 'label' => 'Number of volunteers needed', 'help' => "This determines how many slots are available for the shift.", 'value' => $schedule->volunteers])
        @include('partials/roles', ['roles' => json_decode($schedule->getRoles()), 'help' => "By default, roles will be inherited from the department. You can use these options to override the default."])

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="/event/{{ $schedule->event->id }}" class="btn btn-primary">Cancel</a>
        
    {!! Form::close() !!}
@endsection
