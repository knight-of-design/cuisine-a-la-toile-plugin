/**
 * Cuisine Timer Countdown Functionality
 */

jQuery(function($){

/* Function that resets the timer */
    function resetTimer($timer){
        var time = "" + $timer.data('time'),
            clock =  $timer.data('flipclock');
        // Parse colon separated time value - only support up to two colons
        time = time.split(':').reverse();
        time = parseInt(time[0] || 0,10) + 60*parseInt(time[1] || 0,10) + 60 * parseInt(time[2] || 0,10);

        clock.setTime(time);
    }

    $('.cuisine-timer').each(function(){
        var $timer = $(this),
            clock = $timer.find('.flipclock').FlipClock({
                autoStart: false,
                countdown: true
            });

        $timer.data('flipclock',clock);
        resetTimer($timer);

    });

/* Function to start the clock */
    function startClock(){
        var $timer = $(this).closest('.cuisine-timer'),
            clock = $timer.data('flipclock');

        function playAudio(){
            $timer.find('audio')[0].play();
        }
        clock.start(function(){
            if (clock.getTime() == 0){
                setTimeout(playAudio,1500);
            }

        });
    }

    $(document).on('click', '.start-button', startClock);

/* Function to pause the clock */
    function pauseClock(){
        var clock = $(this).closest('.cuisine-timer').data('flipclock');
        clock.stop();
    }

    $(document).on('click', '.pause-button', pauseClock);

    function resumeClock(){
        var clock = $(this).closest('.cuisine-timer').data('flipclock');
        clock.start();
    }

    $(document).on('click', '.paus-button', startClock);

/* Function to restart the clock */
    function restartClock(){
        var $timer = $(this).closest('.cuisine-timer');
        resetTimer($timer);
    }

    $(document).on('click', '.restart-button', restartClock);

});
