<?php

    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT);
    if (mysqli_connect_errno()) {
        ?>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <img src="/storage/images/logo.png" class="mx-auto w-1/6 mt-6" alt="<?php echo CONFIG_SITE_NAME; ?>">
        <p class="w-full text-center text-xl font-bold mt-8">Saturn Error Recovery.</p>
        <p class="w-full text-center">Sorry, an fatal error has occurred whilst trying to display this page and Saturn was unable to recover.</p>
        <p class="w-full text-center">This should not affect any saved data.</p>
        <?php if (!CONFIG_DEBUG) { ?>
        <div class="duration-300 transform bg-red-100 border-l-4 border-red-500 mt-32 mx-32">
            <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                <h6 class="mb-2 font-semibold leading-5">[<?php date('H:i') ?>]
                <span class="font-medium">Failed to connect to MySQL Database. Please check your website's configuration file and try again. Enable debug mode for more information.</span></h6>
            </div>
        </div>
        <?php } else { ?>
        <div class="duration-300 transform bg-red-100 border-l-4 border-red-500 mt-32 mx-32">
            <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                <h6 class="mb-2 font-semibold leading-5">[<?php date('H:i') ?>]
                <span class="font-medium">Failed to connect to MySQL Database. Please check your website's configuration file and try again. More information below.</span></h6>
            </div>
        </div>
        <p class="bg-black text-white p-2 rounded w-auto mt-8 mx-32">
            MYSQLI_CONNECT_ERRNO(<?php echo mysqli_connect_errno(); ?>) - <?php echo mysqli_connect_error($conn); ?>
        </p>
        <?php } ?>
        <a href="https://saturncms.net" target="_blank" rel="noopener"><img src="/assets/panel/images/saturn.png" class="mx-auto w-32 mt-96" alt="Saturn"></a>
        <p class="w-full text-center text-xs">Powered by Saturn</p>
<?php
        exit;
    }
