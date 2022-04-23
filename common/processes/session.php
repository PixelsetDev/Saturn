<?php

    function countdownJavascript(): string
    {
        $time = ini_get('session.gc_maxlifetime');

        return
        '
        var timeleft = '.$time.';
        var downloadTimer = setInterval(function(){
            if(timeleft <= 60) {
                minsLeft = 1;
            } else if(timeleft <= 120) {
                minsLeft = 2;
            } else if(timeleft <= 180) {
                minsLeft = 3;
            } else if(timeleft <= 240) {
                minsLeft = 4;
            } else if(timeleft <= 300) {
                minsLeft = 5;
            }
            if(timeleft <= 0){
                clearInterval(downloadTimer);
                document.getElementById("sessionCountdown").innerHTML = "<div class=\"bg-red-50 dark:bg-red-500 border-l-4 border-red-500 dark:border-red-900 dark:text-white p-2 shadow-xl flex transition duration-200\"><i class=\"px-2 fas fa-times text-red-500 dark:text-red-900 fa-2x self-center\" aria-hidden=\"true\"></i><h6 class=\"p-3 font-semibold leading-5\">Your session has expired. If you attempt to make any changes it may result in your work being lost. Please <a href=\"/panel\" class=\"underline\" target=\"_blank\" onclick=\"clearCountdown();\">click here</a> to log back in.</h6></div>";
            } else if (timeleft == 9 || timeleft == 7 || timeleft == 5 || timeleft == 3 || timeleft == 1) {
                document.getElementById("sessionCountdown").innerHTML = "<div class=\"bg-yellow-50 dark:bg-yellow-500 border-l-4 border-yellow-500 dark:border-yellow-900 dark:text-white p-2 shadow-xl flex transition duration-200\"><i class=\"px-2 fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-900 fa-2x self-center\" aria-hidden=\"true\"></i><h6 class=\"p-3 font-semibold leading-5\">Your session will expire in " + timeleft + " seconds. Please save your work now.</h6></div>";
            } else if (timeleft == 10 || timeleft == 8 || timeleft == 6 || timeleft == 4 || timeleft == 2) {
                document.getElementById("sessionCountdown").innerHTML = "<div class=\"bg-red-50 dark:bg-red-500 border-l-4 border-red-500 dark:border-red-900 dark:text-white p-2 shadow-xl flex transition duration-200\"><i class=\"px-2 fas fa-exclamation-triangle text-red-500 dark:text-red-900 fa-2x self-center\" aria-hidden=\"true\"></i><h6 class=\"p-3 font-semibold leading-5\">Your session will expire in " + timeleft + " seconds. Please save your work now.</h6></div>";
            } else if (timeleft < 60) {
                document.getElementById("sessionCountdown").innerHTML = "<div class=\"bg-yellow-50 dark:bg-yellow-500 border-l-4 border-yellow-500 dark:border-yellow-900 dark:text-white p-2 shadow-xl flex transition duration-200\"><i class=\"px-2 fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-900 fa-2x self-center\" aria-hidden=\"true\"></i><h6 class=\"p-3 font-semibold leading-5\">Your session will expire in " + timeleft + " seconds. Please save your work now.</h6></div>";
            } else if (timeleft < 120) {
                document.getElementById("sessionCountdown").innerHTML = "<div class=\"bg-yellow-50 dark:bg-yellow-500 border-l-4 border-yellow-500 dark:border-yellow-900 dark:text-white p-2 shadow-xl flex transition duration-200\"><i class=\"px-2 fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-900 fa-2x self-center\" aria-hidden=\"true\"></i><h6 class=\"p-3 font-semibold leading-5\">Your session will expire in " + minsLeft + " minutes. Please save your work now.</h6></div>";
            } else if (timeleft < 300) {
                document.getElementById("sessionCountdown").innerHTML = "<div class=\"bg-yellow-50 dark:bg-yellow-500 border-l-4 border-yellow-500 dark:border-yellow-900 dark:text-white p-2 shadow-xl flex transition duration-200\"><i class=\"px-2 fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-900 fa-2x self-center\" aria-hidden=\"true\"></i><h6 class=\"p-3 font-semibold leading-5\">Your session will expire in " + minsLeft + " minutes.</h6></div>";
            }
            timeleft -= 1;
        }, 1000);
        
        function clearCountdown() {
            document.getElementById("sessionCountdown").innerHTML = "";
        }
        ';
    }
