<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $items;
    public function __construct($items) {
        $this->items = $items;
    }
    public function collection()
    {
        return $this->items->map(function($item) {

            // $device=Device::query()
            // ->where('device_id',$item->device_id)
            // ->where('bundle_id',$item->bundle_id)
            // ->where('event_name',$item->event_name)
            // ->first();
            return [
                'bundle_id' => $item->bundle_id,
                'device_id' => $item->device_id,
                'event_name' => $item->event_name,
                'created_at' => $item->created_at,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Bundle ID',
            'Device ID',
            'Event Name',
            'Created At',
        ];
    }
}
