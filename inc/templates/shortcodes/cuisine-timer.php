<div class="cuisine-timer text-<?=esc_attr($color)?> font-<?=esc_attr($font)?>" data-time="<?=esc_attr($time)?>">
    <div class="flipclock" ></div>
    <audio>
        <source src="<?=$PLUGIN_DIR.'/assets/sounds/'.esc_attr($sound)?>.mp3" type="audio/mpeg">
    </audio>
    <button type="button" class="start-button color-<?=$colorstartbutton?>"> Start </button>
    <button type="button" class="pause-button color-<?=$colorpausebutton?>"> Pause </button>
    <button type="button" class="restart-button color-<?=$colorrestartbutton?>"> Restart </button>
</div>