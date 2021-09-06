<?php

/**
 * alert(type,message,static) Creates an alert box.
 *
 * @param $type
 * @param $message
 * @param false $static
 *
 * @return string
 */
function alert($type, $message, $static = false): string
{
    $message = checkOutput('HTML', $message);
    $message = stripslashes($message);

    if ($static == false ) {
        $alert = '<br>';
    } else {
        $alert = '';
    }

    if ($type == 'ERROR' && $static == false) {
        $alert .= '<div class="duration-300 transform bg-red-50 border-l-4 border-red-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-3 fas fa-times text-red-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
        if (LOGGING_AUTOLOG) { log_file('AUTOLOG][ALERT:ERROR',$message); }
    } elseif ($type == 'WARNING' && $static == false) {
        $alert .= '<div class="duration-300 transform bg-yellow-50 border-l-4 border-yellow-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-exclamation-triangle text-yellow-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
        if (LOGGING_AUTOLOG) { log_file('AUTOLOG][ALERT:WARNING',$message); }
    } elseif ($type == 'SUCCESS' && $static == false) {
        $alert .= '<div class="duration-300 transform bg-green-50 border-l-4 border-green-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-check-circle text-green-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'INFO' && $static == false) {
        $alert .= '<div class="duration-300 transform bg-blue-50 border-l-4 border-blue-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-5 fas fa-info text-blue-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($static == false) {
        $alert .= '<div class="duration-300 transform bg-gray-50 border-l-4 border-gray-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-bell text-gray-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'ERROR' && $static == true) {
        $alert .= '<div class="bg-red-50 border-l-4 border-red-500">
                                    <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                        <i class="px-3 fas fa-times text-red-500 fa-2x self-center" aria-hidden="true"></i>
                                        <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                    </div>
                                </div>';
        if (LOGGING_AUTOLOG) { log_file('AUTOLOG][ALERT:ERROR',$message); }
    } elseif ($type == 'WARNING' && $static == true) {
        $alert .= '<div class="bg-yellow-50 border-l-4 border-yellow-500">
                                    <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                        <i class="px-2 fas fa-exclamation-triangle text-yellow-500 fa-2x self-center" aria-hidden="true"></i>
                                        <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                    </div>
                                </div>';
        if (LOGGING_AUTOLOG) { log_file('AUTOLOG][ALERT:WARNING',$message); }
    } elseif ($type == 'SUCCESS' && $static == true) {
        $alert .= '<div class="bg-green-50 border-l-4 border-green-500">
                                    <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                        <i class="px-2 fas fa-check-circle text-green-500 fa-2x self-center" aria-hidden="true"></i>
                                        <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                    </div>
                                </div>';
    } elseif ($type == 'INFO' && $static == true) {
        $alert .= '<div class="bg-blue-50 border-l-4 border-blue-500">
                                    <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                        <i class="px-5 fas fa-info text-blue-500 fa-2x self-center" aria-hidden="true"></i>
                                        <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                    </div>
                                </div>';
    } else {
        $alert .= '<div class="bg-gray-50 border-l-4 border-gray-500">
                                    <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                        <i class="px-2 fas fa-bell text-gray-500 fa-2x self-center" aria-hidden="true"></i>
                                        <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                    </div>
                                </div>';
    }

    return $alert;
}