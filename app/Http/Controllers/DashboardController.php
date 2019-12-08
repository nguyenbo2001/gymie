<?php

namespace App\Http\Controllers;

use Auth;
use App\Member;
use Javascript;
use App\Enquiry;
use App\Expense;
use App\Setting;
use App\SmsLog;
use App\Followup;
use App\Subscription;
use App\ChequeDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        Javascript::put([
            'jsRegistrationsCount' => \Utilities::registrationsTrend(),
            'jsMembersPerPlan' => \Utilities::membersPerPlan(),
        ]);

        $expirings = Subscription::dashboardExpiring()->paginate();
        $expiringTotal = Subscription::dashboardExpiring()->get();
        $expiringCount = $expiringTotal->count();
        $allExpired = Subscription::dashboardExpired()->paginate(5);
        $allExpiredTotal = Subscription::dashboardExpired()->get();
        $expiredCount = $allExpiredTotal->count();
        $birthdays = Member::birthday()->get();
        $birthdayCount = $birthdays->count();
        $recents = Member::recent()->get();
        $enquiries = Enquiry::onlyLeads()->get();
        $reminders = Followup::reminders()->count();
        $reminderCount = $reminders->count();
        $dues = Expense::dueAlerts()->get();
        $outstandings = Expense::outstandingAlerts()->get();
        $smsRequestSetting = \Utilities::getSetting('sms_request');
        $smslogs = SmsLog::dashboardLogs()->get();
        $recievedCheques = ChequeDetail::where('status', \constChequeStatus::Recieved)->get();
        $recivedChequesCount = $recievedCheques->count();
        $depositedCheques = ChequeDetail::where('status', \constChequeStatus::Deposited)->get();
        $depositedChequesCount = $depositedCheques->count();
        $bouncedCheques = ChequesDetail::where('status', \constChequesStatus::Bounced)->get();
        $bouncedChequesCount = $bouncedCheques->count();
        $membersPerPlan = json_decode(\Utilities::membersPerPlan());

        return view('dashboard.index', compact('expirings', 'allExpired',
                                                'birthdays', 'recents',
                                                'enquiries', 'reminders',
                                                'dues', 'outstandings',
                                                'smsRequestSetting', 'smslogs',
                                                'expiringCount', 'expiredCount',
                                                'birthdayCount', 'reminderCount',
                                                'recievedCheques', 'recievedChequesCount',
                                                'depositedCheques', 'depositedChequesCount',
                                                'bouncedCheques', 'bouncedChequesCount',
                                                'membersPerPlan'));
    }

    public function smsRequest(Request $request) {
        $contact = 12213123;
        $sms_text = 'A request for '.$request->smsCount. 'sms has came from'. \Utilities::setSetting('gym_name'). ' by '. Auth::user()->name;
        $sms_status = 1;
        \Utilities::Sms($contact, $sms_text, $sms_status);

        Setting::where('key', '=', 'sms_request')
                ->update(['value' => 1]);

        flash()->success('Request has been successfully sent, a comfirmation call will be made soon');

        return redirect('/dashboard');
    }
}