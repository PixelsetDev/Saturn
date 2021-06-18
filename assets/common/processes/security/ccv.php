<?php

    function ccv_validate($file): bool
    {
        if ($file == 'CONFIG') {
            $file = file_get_contents(__DIR__.'/../../../../config.php');

            return checksum_validate($file, CCV_CONFIG);
        } else {
            return false;
        }
    }

    function ccv_reset(): bool
    {
        $file1 = file_get_contents(__DIR__.'/../../../../config.php');

        $newChecksum1 = checksum_generate($file1);

        $message = "<?php
        // You shouldn't change these values. If you do, it can cause errors to appear within Saturn.
        const CCV_CONFIG = '".$newChecksum1."';";

        $csfile = __DIR__.'/../../../storage/core_checksum.php';

        return file_put_contents($csfile, $message, LOCK_EX);
    }

    function ccv_validate_all()
    {
        if (!ccv_validate('CONFIG')) {
            echo '<div class="bg-yellow-100 border-l-4 border-yellow-500 hover:-translate-y-2">
                                    <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                        <h6 class="mb-2 font-semibold leading-5">[WARNING] CCV: Website configuration does not match checksum. <a href="https://docs.saturncms.net/website-configuration-checksum" class="underline text-xs text-black" target="_blank">Get help.</a></h6>
                                    </div>
                                </div>';
        }
    }
