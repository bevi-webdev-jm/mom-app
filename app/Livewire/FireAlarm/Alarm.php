<?php

namespace App\Livewire\FireAlarm;

use Livewire\Component;
use App\Models\SystemSetting;

class Alarm extends Component
{
    public bool $alarmTriggered = false;
    public $sound;
    public $title;

    protected $listeners = ['triggerAlarm'];

    public function render()
    {
        $this->loadAlarmState();
        return view('livewire.fire-alarm.alarm');
    }
    
    public function mount(): void
    {
        $this->loadAlarmState();
    }

    public function pollAlarmState(): void
    {
        $this->loadAlarmState();
    }

    public function triggerAlarm(): void
    {
        if($this->title == 'Fire Alarm') {
            SystemSetting::query()->update(['fire_alarm_on' => true]);
            SystemSetting::query()->update(['alarm_on' => false]);
        } else {
            SystemSetting::query()->update(['alarm_on' => true]);
            SystemSetting::query()->update(['fire_alarm_on' => false]);
        }
        $this->alarmTriggered = true;
    }

    public function loadAlarmState(): void
    {
        if($this->title == 'Fire Alarm') {
            $this->alarmTriggered = SystemSetting::first()->fire_alarm_on ?? false;
        } else {
            $this->alarmTriggered = SystemSetting::first()->alarm_on ?? false;
        }
    }

    public function resetAlarm(): void
    {
        SystemSetting::query()->update(['fire_alarm_on' => false]);
        SystemSetting::query()->update(['alarm_on' => false]);
        $this->alarmTriggered = false;
    }
}
