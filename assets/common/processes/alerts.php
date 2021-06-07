<?php
function alert($type,$message) {
    if($type == 'ERROR') {
        echo '<br>
                            <div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                                <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">' . $message . '</h6>
                                </div>
                            </div>';
    }
}