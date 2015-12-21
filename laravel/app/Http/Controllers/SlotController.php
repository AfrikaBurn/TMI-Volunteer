<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\SlotRequest;
use App\Models\Slot;

use Illuminate\Support\Facades\Auth;

use App\Events\SlotChanged;
use Event;
use Carbon\Carbon;

class SlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Helper function to determine if an event has passed
    private function eventHasPassed(Slot $slot)
    {
        $start_date = new Carbon($slot->start_date);

        if($start_date->lt(Carbon::now()))
        {
            return true;
        }

        return false;
    }

    // Helper function to determine allowed roles
    private function userAllowed(Slot $slot, $type)
    {
        $user = Auth::user();
        $roles = ($slot->shift->roles) ? $slot->shift->roles : $slot->department->roles;
        $roles = json_decode($roles);
        $allowed = false;

        // Check each allowed role to see if the user has permission
        foreach($roles as $role)
        {
            $action = implode('-', [$type, $role, 'slot']);
            
            if($user->can($action))
            {
                $allowed = true;
            }
        }

        return $allowed;
    }

    
    // View form to take an existing slot
    public function takeForm(Request $request, Slot $slot)
    {
        return view('pages/slot/take', compact('slot'));
    }

    // Add yourself to an existing slot
    public function take(SlotRequest $request, Slot $slot)
    {
        if(!$this->userAllowed($slot, 'take'))
        {
            $request->session()->flash('error', 'This shift is only available to certain user groups, your account must be approved by an administrator before signing up.');
        }
        else
        {
            if($this->eventHasPassed($slot))
            {
                $request->session()->flash('error', 'This event has already passed, you are no longer able to sign up for shifts.');
            }
            else
            {
                if(is_null($slot->user))
                {
                    $slot->user_id = Auth::user()->id;
                    $slot->save();
                    
                    Event::fire(new SlotChanged($slot, ['status' => 'taken', 'name' => Auth::user()->name]));
                    $request->session()->flash('success', 'You signed up for a volunteer shift.');
                }
                else
                {
                    $request->session()->flash('error', 'This slot has already been taken by someone else.');
                }
            }
        }
        
        return redirect('/event/' . $slot->event->id);
    }

    // View confirmation page before releasing a slot
    public function releaseForm(Request $request, Slot $slot)
    {
        return view('pages/slot/release', compact('slot'));
    }

    // Remove yourself from a slot
    public function release(Request $request, Slot $slot)
    {
        if(!$this->userAllowed($slot, 'release'))
        {
            $request->session()->flash('error', 'This shift is only available to certain user groups, your account must be approved by an administrator before signing up.');
        }
        else
        {
            if($this->eventHasPassed($slot))
            {
                $request->session()->flash('error', 'This event has already passed, you are no longer able to sign up for shifts.');
            }
            else
            {
                if(!is_null($slot->user) && $slot->user->id === Auth::user()->id)
                {
                    $slot->user_id = null;
                    $slot->save();

                    Event::fire(new SlotChanged($slot, ['status' => 'released']));
                    $request->session()->flash('success', 'You are no longer volunteering for your shift.');
                }
                else
                {
                    $request->session()->flash('error', 'You are not currently scheduled to volunteer for this shift.');
                }
            }
        }

        return redirect('/event/' . $slot->event->id);
    }
}
