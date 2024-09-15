<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeviceExport implements FromCollection, WithHeadings
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
            return [
                'bundle_id' => $item->bundle_id,
                'device_id' => $item->device_id,
                'idfa' => $item->idfa,
                'device_model' => $item->device_model,
                'is_onboarding_completed' => $item->is_onboarding_completed,
                'is_trial_started' => $item->is_trial_started,
                'is_directly_subscribed' => $item->is_directly_subscribed,
                'is_trial_converted' => $item->is_trial_converted,
                'created_at' => $item->created_at,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Bundle ID',
            'Device ID',
            'IDFA',
            'Model',
            'Onboarding Completed',
            'Trial Started',
            'Directly Subscribed',
            'Trial Converted',
            'Created At',
        ];
    }
}
