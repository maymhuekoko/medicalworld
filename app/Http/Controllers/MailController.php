<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MailMarketing;
use App\EmailField;
use App\ContactMessage;

class MailController extends Controller
{

    public function MailMarketingForm() {
        return view('Admin.email_marketing');
    }

    public function SendingMail(Request $request) {

        $emailF = new EmailField;

        $emailF->subject = $request->subject;
        $emailF->title = $request->title;
        $emailF->subtitle = $request->subtitle;
        $emailF->description = $request->description;
        $emailF->link = $request->link;

        $photoName = time().'_'.$request->photo->getClientOriginalName();
        $photoPath = $request->file('photo')->move(public_path('/uploadedfiles'), $photoName);
        $emailF->photo = time().'_'.$request->photo->getClientOriginalName();

        $attachName = time().'_'.$request->attach->getClientOriginalName();
        $attachPath = $request->file('attach')->move(public_path('/uploadedfiles'), $attachName);
        $emailF->attach = time().'_'.$request->attach->getClientOriginalName();

        $emailF->save();

        $subscribers = ContactMessage::where('subscribe_flag', '1')->get('email');

        foreach ($subscribers as $s) {
            Mail::to($s)
            ->send(new MailMarketing($request->subject,$request->title,$request->subtitle,$request->description,$request->link,$photoName,$attachName));
        }
        
        return redirect()->back()->with('success', 'Mail send successfully!');
        
    }
}
