<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventV2Export implements FromCollection, WithHeadings
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

        return $this->items['group_by']->map(function($item) {
            if($this->items['s_group_by']=='month' || $this->items['s_group_by']=='week')
            {
               $date= $item['start_date'].'/'.$item['end_date'];
            }
            else
            {
                $date=$item['start_date'];
            }
           if($this->items['s_event_type']=='ration')
            {
                $is_onboarding_completed='%'.$item['is_onboarding_completed']['ration'];
            }
            else
            {
                $is_onboarding_completed=$item['is_onboarding_completed']['number'];
            }


            if($this->items['s_event_type']=='ration')
            {
                $is_trial_started='%'.$item['is_trial_started']['ration'];
            }
                                else
            {
                $is_trial_started=$item['is_trial_started']['number'];
            }


            if($this->items['s_event_type']=='ration')
            {
                $to_be_paid='%'.$item['to_be_paid']['ration'];
            }
                                else
            {
                $to_be_paid=$item['to_be_paid']['number'];
            }

            if($this->items['s_event_type']=='ration')
            {
                $is_directly_subscribed='%'.$item['is_directly_subscribed']['ration'];
            }
                                 else
            {
                $is_directly_subscribed=$item['is_directly_subscribed']['number'];
            }


            return [
                'date'=>$date,
                'is_onboarding_completed' => $is_onboarding_completed,
                'is_trial_started' => $is_trial_started,
                'to_be_paid' => $to_be_paid,
                'is_directly_subscribed' => $is_directly_subscribed,
            ];
        });
    }
    public function headings(): array
    {
        return [
            ($this->items['s_event_type']=='number'?'#':'').'Event Date'.($this->items['s_event_type']=='ration'?' Rate':''),
            ($this->items['s_event_type']=='number'?'#':'').'Onboarding Completion'.($this->items['s_event_type']=='ration'?' Rate':''),
            ($this->items['s_event_type']=='number'?'#':'').'Trial Start'.($this->items['s_event_type']=='ration'?' Rate':''),
            ($this->items['s_event_type']=='number'?'#':'').'Trial To Paid'.($this->items['s_event_type']=='ration'?' Rate':''),
            ($this->items['s_event_type']=='number'?'#':'').'Direct Subscription'.($this->items['s_event_type']=='ration'?' Rate':''),
        ];
    }
}
