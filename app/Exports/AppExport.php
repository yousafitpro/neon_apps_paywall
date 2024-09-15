<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AppExport implements FromCollection, WithHeadings
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
                'app_id' => $item->info->app_id,
                'onboarding' => $item->onboarding,
                'trial_started' => $item->trial_started,
                'directly_subscribed' => $item->directly_subscribed,
                'trial_converted' => $item->trial_converted,
                'registered_device_count' => $item->registered_device_count,
                'created_at' => $item->info->created_at,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Bundle ID',
            'App ID',
            'Onboarding',
            'Trial Started',
            'Directly Subscribed',
            'Trial Converted',
            'Registered Device Count',
            'Created At',
        ];
    }
}
