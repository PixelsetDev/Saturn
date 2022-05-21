<?php

    function ccv_validate($file): bool
    {
        if ($file == 'CONFIG') {
            $file = file_get_contents(__DIR__.'/../../../config.php');

            return checksum_validate($file, CCV_CONFIG);
        } else {
            return false;
        }
    }

    function ccv_reset(): bool
    {
        $file1 = file_get_contents(__DIR__.'/../../../config.php');

        $newChecksum1 = checksum_generate($file1);

        $message = "<?php
        // You shouldn't change these values. If you do, it can cause errors to appear within Saturn.
        const CCV_CONFIG = '".$newChecksum1."';";

        $csfile = __DIR__.'/../../../storage/core_checksum.php';

        return file_put_contents($csfile, $message, LOCK_EX);
    }

    function ccv_validate_all()
    {
        if (!ccv_validate('CONFIG') && !isset($_GET['successResetCCV'])) {
            echo alert('WARNING', 'CCV: Website configuration does not match checksum. <a href="https://docs.saturncms.net/'.SATURN_VERSION.'/warnings/#website-configuration-checksum" class="underline text-xs text-black" target="_blank" rel="noopener">Get help.</a>', true);
        }
    }
