<div
    {{-- 1. Initialize all state variables directly in x-data --}}
    x-data="{
        alarmTriggered: @entangle('alarmTriggered'),
        audioUnlocked: false,
        alarmHasPlayed: false
    }"

    {{-- 2. Watch for state changes within the local Alpine scope --}}
    x-init="
        const audio = $refs.alarmAudio;

        $watch('alarmTriggered', (value) => {
            // Check if audio is unlocked before playing
            if (value && audioUnlocked && !alarmHasPlayed) {
                audio.play().then(() => {
                    alarmHasPlayed = true;
                }).catch(err => console.error('Failed to play alarm:', err));
            } else if (!value) {
                audio.pause();
                audio.currentTime = 0;
                alarmHasPlayed = false;
            }
        });
    "

    {{-- 3. Use a local click listener instead of a global one --}}
    @click.once="
        if (!audioUnlocked) {
            const audio = $refs.alarmAudio;
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
                audioUnlocked = true;
            }).catch(() => {});
        }
    "

    {{-- Add a check for the polling method --}}
    wire:poll.1s="loadAlarmState"
>
    <div class="row">
        <div class="col-lg-6 py-2">
            <button wire:click="triggerAlarm" class="btn btn-primary btn-lg btn-block py-5">
                <i class="fa fa-volume-up fa-xl mr-2"></i>
                <span class="text-lg">{{$title}}</span>
            </button>
        </div>
        @if($alarmTriggered)
            <div class="col-lg-6 py-2">
                <button wire:click="resetAlarm" class="btn btn-secondary btn-lg btn-block py-5">
                    <i class="fa fa-ban fa-xl mr-1"></i>
                    <span class="text-lg"> Reset Alarm</span>
                </button>
            </div>
        @endif
    </div>

    {{-- The audio element remains the same --}}
    <audio x-ref="alarmAudio" src="{{ $sound }}" loop style="display:none;"></audio>

    <div class="mt-2 text-sm text-gray-500">
        Alarm State: <i class="fa fa-circle {{$alarmTriggered ? 'text-success' : 'text-danger'}}"></i> <span x-text="alarmTriggered ? 'ON' : 'OFF'"></span>
    </div>
</div>