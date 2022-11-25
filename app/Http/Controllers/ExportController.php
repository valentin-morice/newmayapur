<?php

namespace App\Http\Controllers;

use App\Exports\MembersExport;
use App\Exports\PaymentsExport;
use App\Models\Members;
use App\Models\Payments;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function create()
    {
        return Inertia::render('AdminExport', [
            'currencies_payments' => Payments::pluck('currency')->unique(),
            'currencies_members' => Subscriptions::pluck('currency')->unique(),
            'payment_status' => Payments::pluck('status')->unique(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['object' => 'required']);

        $date_start = $this->format_date($request->input('date_start'));
        $date_end = $this->format_date($request->input('date_end'));

        if ($request->input('filtered') === 'false') {
            if ($request->input('object') === 'members') {
                return Excel::download(new MembersExport, 'members_all.xlsx');
            } else {
                return Excel::download(new PaymentsExport, 'payments_all.xlsx');
            }
        } else {
            if ($request->input('object') === 'payments') {
                return Excel::download(new PaymentsExport($date_start, $date_end, $request->input('currency'), $request->input('status')), 'payments_filtered.xlsx');
            } else {
                return Excel::download(new MembersExport($date_start, $date_end, $request->input('currency'), $request->input('status')), 'export.xlsx');
            }
        }
    }

    private function format_date($date)
    {
        if ($date === "null") return null;

        $formatted = strtotime(substr($date, 4, 11));
        return gmdate("Y-m-d\ H:i:s\Z", $formatted);
    }
}
