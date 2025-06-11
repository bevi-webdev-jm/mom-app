<div wire:poll.1s="loadAlarmState" x-data="{ alarmTriggered: @entangle('alarmTriggered') }" x-init="
    const audio = $refs.alarmAudio;
    let audioUnlocked = false;
    let alarmHasPlayed = false;

    function unlockAudio() {
        if (!audioUnlocked) {
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
                audioUnlocked = true;
                window.audioWasUnlocked = true;
            }).catch(() => {});
        }
    }

    // Unlock audio on first user interaction
    window.addEventListener('click', unlockAudio, { once: true });

    // Watch for changes in alarmTriggered
    $watch('alarmTriggered', value => {
        console.log('alarmTriggered changed:', value);
        if (value && audioUnlocked && !alarmHasPlayed) {
            console.log('Playing alarm sound');
            audio.play().then(() => {
                alarmHasPlayed = true;
            }).catch(err => {
                console.error('Failed to play alarm:', err);
            });
        } else if (!value) {
            console.log('Stopping alarm sound');
            audio.pause();
            audio.currentTime = 0;
            alarmHasPlayed = false;
        }
    });
">
    <div class="row">
        <div class="col-lg-6 py-2">
            <button wire:click="triggerAlarm" class="btn btn-primary btn-lg btn-block py-5">
                <span class="text-lg">🔥 Trigger Alarm</span>
            </button>
        </div>
        <div class="col-lg-6 py-2">
            <button wire:click="resetAlarm" class="btn btn-secondary btn-lg btn-block py-5">
                <span class="text-lg">🧯 Reset Alarm</span> 
            </button>
        </div>
        
    </div>

    <audio x-ref="alarmAudio" src="{{ asset('sounds/Emergency Alarm Rev3.mp3') }}" loop style="display:none;"></audio>

    <div class="mt-2 text-sm text-gray-500">
        Alarm State: <span x-text="alarmTriggered ? 'ON' : 'OFF'"></span>
    </div> 
</div>
