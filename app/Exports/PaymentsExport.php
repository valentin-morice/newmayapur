<?php

namespace App\Exports;

use App\Models\Payments;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    private mixed $start_date;
    private mixed $end_date;
    private mixed $currency;
    private mixed $status;

    public function __construct($start_date = null, $end_date = null, $currency = null, $status = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->currency = $currency;
        $this->status = $status;
    }

    public function query()
    {
        $query = Payments::query();

        if (!is_null($this->status)) {
            $query->where('status', $this->status);
        }
        if (!is_null($this->currency)) {
            $query->where('currency', $this->currency);
        }
        if (!is_null($this->start_date)) {
            $query->whereDate('created_at', '>=', date($this->start_date));
        }
        if (!is_null($this->end_date)) {
            $query->whereDate('created_at', '<=', date($this->end_date));
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'id',
            'created_at',
            'updated_at',
            'payment_id',
            'name',
            'email',
            'status',
            'currency',
            'amount',
        ];
    }
}
