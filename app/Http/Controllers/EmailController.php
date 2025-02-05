<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Http\Requests\EmailRequest;
use App\Mail\Email;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailController extends Controller
{
    /**
     * Render the view with the form to compose email
     */
    public function emailForm(Request $request): View
    {
//        Gate::authorize('edit', $group);

        return view('email-form', [
            'group_id' => $request->get('group_id'),
            'event_id' => $request->get('event_id'),
            'type' => $request->get('type')
        ]);
    }

    /**
     * Receive email message, generate recipients and send to mailer
     */
    public function send(EmailRequest $request): View
    {
        $validated = $request->validated();
        $subject = $validated['subject'];
        $emailmessage =  $validated['message']; // message is a reserved word with Mail
        $type =  $validated['type'];
        $group_id =  $validated['group_id'];
        $event_id = $validated['event_id'];

        $recipient_ids = [];

        if($type == 'group-admin') {
            $recipient_ids = GroupUser::select('user_id')
                ->where('group_id', $group_id)
                ->where('role', UserRoleEnum::ADMIN)->get();
        }
        if($type == 'admin-group') {
            $recipient_ids = GroupUser::select('user_id')
                ->where('group_id', $group_id)->get();
        }
        if($type == 'event-creator-attendees') {
            $recipient_ids = EventUser::select('user_id')
                ->where('event_id', $event_id)->get();
        }
        if($type == 'attendees-event-creator') {
            $recipient_ids = Event::select('creator_id AS user_id')
                ->where('id', $event_id)->get();
        }

        if(empty($recipient_ids)) {
            return view('email-none');
        }

//        $group = Group::find($group_id);
//        $event = Event::find($event_id);
        $sender = Auth::user()->name;

        $emails = [];

        foreach($recipient_ids as $recipient) {
            $email = User::select('email')->where('id', $recipient->user_id)->first();
            array_push($emails, $email->email);
        }

        // dd($emails);

        foreach($emails as $email) {
            Mail::to($email)->send(new Email($subject, $emailmessage, $sender));
        }

        return view('email-sent');
    }
}
