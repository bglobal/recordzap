<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromQuery, WithMapping, WithHeadings
{
    public $orders = [];
    use Exportable;


    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function query()
    {
        return Order::query()->whereIn('entry_id', $this->orders);
    }


    public function map($orders): array
    {
        return [
            $orders->entry_id,
            $orders->order_form->post_title,
            $orders->status,
            !empty($orders->meta) ? "$" . $orders->meta->payment_total : "0.00",
            $orders->date,
        ];
    }

    public function headings(): array
    {
        return [
            'Entry ID',
            'Form Name',
            'Status',
            'Amount',
            'Date',
        ];
    }
}
