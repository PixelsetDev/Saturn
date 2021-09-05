<?php

/**
 * alert(type,message) Creates an alert box.
 *
 * @param $type
 * @param $message
 *
 * @return bool
 */
function alert($type, $message): bool
{
    $message = checkOutput('DEFAULT', $message);
    $message = stripslashes($message);

    if ($type == 'ERROR') {
        $alert = '<br>
                            <div class="duration-300 transform bg-red-50 border-l-4 border-red-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-3 fas fa-times text-red-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'WARNING') {
        $alert = '<br><div class="duration-300 transform bg-yellow-50 border-l-4 border-yellow-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-exclamation-triangle text-yellow-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'SUCCESS') {
        $alert = '<br><div class="duration-300 transform bg-green-50 border-l-4 border-green-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-check-circle text-green-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'INFO') {
        $alert = '<br><div class="duration-300 transform bg-blue-50 border-l-4 border-blue-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-5 fas fa-info text-blue-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } else {
        $alert = '<br><div class="duration-300 transform bg-gray-50 border-l-4 border-gray-500 hover:-translate-y-2">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-bell text-gray-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    }

    return $alert;
}

/**
 * static_alert(type,message) Creates an alert box that does not move on hover.
 *
 * @param $type
 * @param $message
 *
 * @return bool
 */
function static_alert($type, $message): bool
{
    $message = checkOutput('DEFAULT', $message);
    $message = stripslashes($message);

    if ($type == 'ERROR') {
        $alert = '<div class="bg-red-50 border-l-4 border-red-500">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-3 fas fa-times text-red-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'WARNING') {
        $alert = '<div class="bg-yellow-50 border-l-4 border-yellow-500">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-exclamation-triangle text-yellow-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'SUCCESS') {
        $alert = '<div class="bg-green-50 border-l-4 border-green-500">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-check-circle text-green-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } elseif ($type == 'INFO') {
        $alert = '<div class="bg-blue-50 border-l-4 border-blue-500">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-5 fas fa-info text-blue-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    } else {
        $alert = '<div class="bg-gray-50 border-l-4 border-gray-500">
                                <div class="p-2 border border-l-0 rounded-r shadow-sm flex">
                                    <i class="px-2 fas fa-bell text-gray-500 fa-2x self-center" aria-hidden="true"></i>
                                    <h6 class="p-3 font-semibold leading-5">'.$message.'</h6>
                                </div>
                            </div>';
    }

    return $alert;
}
