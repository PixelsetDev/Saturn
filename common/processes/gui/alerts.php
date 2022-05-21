<?php

/**
 * alert(type,message,static) Creates an alert box.
 *
 * @param string $type
 * @param string $message
 * @param false  $static
 *
 * @return string
 */
function alert(string $type = 'NOTIFICATION', string $message = '', bool $static = false): string
{
    $message = checkOutput('HTML', $message);
    $message = stripslashes($message);

    if (!$static) {
        $alert = '<br>';
    } else {
        $alert = '';
    }

    if ($type == 'ERROR' && !$static) {
        $alert .= '<div class="transform hover:-translate-y-2 bg-red-50 dark:bg-red-500 dark:text-white border-l-4 border-red-500 dark:border-red-900 p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-times text-red-500 dark:text-red-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
        if (LOGGING_AUTOLOG) {
            log_file('AUTOLOG][ALERT:ERROR', $message);
        }
    } elseif ($type == 'WARNING' && !$static) {
        $alert .= '<div class="transform hover:-translate-y-2 bg-yellow-50 dark:bg-yellow-500 dark:text-white border-l-4 border-yellow-500 dark:border-yellow-900 p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
        if (LOGGING_AUTOLOG) {
            log_file('AUTOLOG][ALERT:WARNING', $message);
        }
    } elseif ($type == 'SUCCESS' && !$static) {
        $alert .= '<div class="transform hover:-translate-y-2 bg-green-50 dark:bg-green-500 dark:text-white border-l-4 border-green-500 dark:border-green-900 p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-check-circle text-green-500 dark:text-green-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
    } elseif ($type == 'INFO' && !$static) {
        $alert .= '<div class="transform hover:-translate-y-2 bg-blue-50 dark:bg-blue-500 dark:text-white border-l-4 border-blue-500 dark:border-blue-900 p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-info text-blue-500 dark:text-blue-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
    } elseif ($type == 'NOTIFICATION' && !$static) {
        $alert .= '<div class="transform hover:-translate-y-2 bg-neutral-50 dark:bg-neutral-500 dark:text-white border-l-4 border-neutral-500 dark:border-neutral-900 dark:text-white p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-bell text-neutral-500 dark:text-neutral-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
    } elseif ($type == 'ERROR' && $static) {
        $alert .= '<div class="bg-red-50 dark:bg-red-500 border-l-4 border-red-500 dark:border-red-900 dark:text-white p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-times text-red-500 dark:text-red-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
        if (LOGGING_AUTOLOG) {
            log_file('AUTOLOG][ALERT:ERROR', $message);
        }
    } elseif ($type == 'WARNING' && $static) {
        $alert .= '<div class="bg-yellow-50 dark:bg-yellow-500 border-l-4 border-yellow-500 dark:border-yellow-900 dark:text-white p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
        if (LOGGING_AUTOLOG) {
            log_file('AUTOLOG][ALERT:WARNING', $message);
        }
    } elseif ($type == 'SUCCESS' && $static) {
        $alert .= '<div class="bg-green-50 dark:bg-green-500 border-l-4 border-green-500 dark:border-green-900 dark:text-white p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-check-circle text-green-500 dark:text-green-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
    } elseif ($type == 'INFO' && $static) {
        $alert .= '<div class="bg-blue-50 dark:bg-blue-500 border-l-4 border-blue-500 dark:border-blue-900 dark:text-white p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-info text-blue-500 dark:text-blue-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
    } else {
        $alert .= '<div class="bg-neutral-50 dark:bg-neutral-500 border-l-4 border-neutral-500 dark:border-neutral-900 dark:text-white dark:text-white p-2 shadow-md hover:shadow-xl flex transition duration-200">
            <i class="px-2 fas fa-bell text-neutral-500 dark:text-neutral-900 fa-2x self-center" aria-hidden="true"></i>
            <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
        </div>';
    }

    return $alert;
}
