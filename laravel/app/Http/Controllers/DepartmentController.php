<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Models\Event;

use App\Events\EventChanged;
use Event;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display department creation page
    public function createForm(Request $request, Event $event)
    {
        $this->authorize('create-department');
        return view('pages/department/create', compact('event'));
    }

    // Create a new department
    public function create(DepartmentRequest $request)
    {
        $this->authorize('create-department');
        $input = $request->all();

        // Convert roles into JSON
        $input['roles'] = json_encode($input['roles']);

        $department = Department::create($input);

        Event::fire(new EventChanged($event, ['type' => 'department', 'status' => 'created']));

        $request->session()->flash('success', 'Your department has been created.');
        return redirect('/event/' . $department->event->id);
    }

    // View form to edit an existing department
    public function editForm(Request $request, Department $department)
    {
        $this->authorize('edit-department');
        return view('pages/department/edit', compact('department'));
    }

    // Save changes to an existing department
    public function edit(DepartmentRequest $request, Department $department)
    {
        $this->authorize('edit-department');
        $input = $request->all();

        // Convert roles into JSON
        $input['roles'] = json_encode($input['roles']);

        $department->update($input);

        Event::fire(new EventChanged($event, ['type' => 'department', 'status' => 'edited']));

        $request->session()->flash('success', 'Department has been updated.');
        return redirect('/event/' . $department->event->id);
    }

    // View confirmation page before deleting an department
    public function deleteForm(Request $request, Department $department)
    {
        $this->authorize('delete-department');
        return view('pages/department/delete', compact('department'));
    }

    // Delete an department
    public function delete(Request $request, Department $department)
    {
        $this->authorize('delete-department');
        $event = $department->event;
        $department->delete();

        Event::fire(new EventChanged($event, ['type' => 'department', 'status' => 'deleted']));

        $request->session()->flash('success', 'Department has been deleted.');
        return redirect('/event/' . $event->id);
    }
}
