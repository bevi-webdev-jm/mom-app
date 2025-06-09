<div wire:poll.1s="loadAlarmState" x-data="{ alarmTriggered: @entangle('alarmTriggered') }" x-init="
    const audio = $refs.alarmAudio;
    let audioUnlocked = false;
    let alarmHasPlayed = false;git 

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
    <div class="space-x-2">
        <button
            wire:click="triggerAlarm"
            class="btn btn-primary"
        >
            🔥 Trigger Alarm
        </button>

        <button wire:click="resetAlarm" class="btn btn-secondary">
            🧯 Reset Alarm
        </button>
    </div>

    <audio x-ref="alarmAudio" src="{{ asset('sounds/alarm.mp3') }}" style="display:none;"></audio>

    <div class="mt-2 text-sm text-gray-500">
        Alarm State: <span x-text="alarmTriggered ? 'ON' : 'OFF'"></span>
    </div>
</div>
