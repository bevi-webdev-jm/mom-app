<?php

namespace App\Livewire\FireAlarm;

use Livewire\Component;
use App\Models\SystemSetting;

class Alarm extends Component
{
    public bool $alarmTriggered = false;

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
        SystemSetting::query()->update(['alarm_on' => true]);
        $this->alarmTriggered = true;
    }

    public function loadAlarmState(): void
    {
        $this->alarmTriggered = SystemSetting::first()->alarm_on ?? false;
    }

    public function resetAlarm(): void
    {
        SystemSetting::query()->update(['alarm_on' => false]);
        $this->alarmTriggered = false;
    }
}
