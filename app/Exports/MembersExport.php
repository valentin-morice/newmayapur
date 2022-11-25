<?php

namespace App\Exports;

use App\Models\Members;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Members
     */
    public function query()
    {
        $query = Members::query();

        if (!is_null($this->status)) {
            $query->whereHas('subscriptions', function ($q) {
                $q->where('status', $this->status);
            });
        }
        if (!is_null($this->currency)) {
            $query->whereHas('subscriptions', function ($q) {
                $q->where('currency', $this->currency);
            });
        }
        if (!is_null($this->start_date)) {
            $query->whereDate('created_at', '>=', date($this->start_date));
        }
        if (!is_null($this->end_date)) {
            $query->whereDate('created_at', '<=', date($this->end_date));
        }

        return $query;
    }

    public function __construct($start_date = null, $end_date = null, $currency = null, $status = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->currency = $currency;
        $this->status = $status;
    }

    public function map($member): array
    {
        return [
            $member->id,
            $member->created_at,
            $member->updated_at,
            $member->name,
            $member->email,
            $member->country,
            $member->city,
            $member->address,
            $member->state,
            $member->postal_code,
            $member->subscriptions[0]->amount,
            $member->subscriptions[0]->currency,
            $member->subscriptions[0]->payment_method,
            $member->subscriptions[0]->status,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'created_at',
            'updated_at',
            'name',
            'email',
            'country',
            'city',
            'address',
            'state',
            'postal_code',
            'amount',
            'currency',
            'payment_method',
            'status'
        ];
    }
}
