<header class="w-full h-auto" aria-label="Header">
            <div class="py-4 px-3 bg-neutral-800 dark:bg-neutral-900">
                <ul class="space-x-2 flex">
                    <li>
                        <a href="/panel" class="flex items-center text-base font-normal text-neutral-900 rounded-lg dark:text-white">
                            <img src="/Assets/Images/SaturnLogo.png" class="h-6" alt="Saturn Logo">
                        </a>
                    </li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li>
                        <a href="/" class="flex items-center text-base font-normal text-neutral-900 rounded-lg dark:text-white">
                            <img src="https://via.placeholder.com/400x100?text=Your+Logo" class="h-6" alt="Your Logo">
                        </a>
                    </li>
                    <li class="flex-grow"></li>
                    <li>
                        <a href="#" class="flex items-center text-base font-normal text-white rounded-lg dark:text-white">
                            <img src="/Assets/Images/BlankPFP.png" class="h-6 rounded-full bg-neutral-700" alt="Lewis Milburn">
                            <span class="ml-2" id="FullName"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <?php global $Plugins; global $API_LOCATION; $Plugins->ExecuteHook('PANEL_HEADER_END'); ?>

        </header>
        <script>
            fetch('<?= $API_LOCATION; ?>/<?= API_VERSION; ?>/user/fullname?username=<?= $_SESSION['username']; ?>')
                .then(response=>response.text())
                .then(data=>{ document.getElementById('FullName').innerText = data; })
        </script>