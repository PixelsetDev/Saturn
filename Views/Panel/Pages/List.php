<?php
use Saturn\ClientKit\SecureArea;
use Saturn\ClientKit\Translate;

$SecureArea = new SecureArea();
$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('Pages'); ?> - <?= WEBSITE_NAME; ?></title>
        <?php global $Plugins; $Plugins->ExecuteHook('PANEL_HEAD_END'); ?>

    </head>
    <body class="dark:bg-black dark:text-white w-full min-h-screen flex flex-col">
        <?php require_once __DIR__.'/../Header.inc'; ?>

        <div class="md:grid xl:grid-cols-8 md:grid-cols-4 w-full flex-grow">
            <?php require_once __DIR__.'/../Sidebar.inc'; ?>

            <div class="h-full w-full py-8 px-10 xl:col-span-7 md:col-span-3">
                <h1 class="text-3xl font-bold mb-8"><?= $TL->TL('Pages'); ?></h1>

                <div id="PageList">

                </div>
            </div>
        </div>

        <script><?php global $API_LOCATION; ?>

            function ShowChild(id) {
                document.getElementById("dropdown-"+id).href = "javascript:HideChild("+id+");";
                document.getElementById("dropdown-"+id).innerHTML = "<i class=\"fa-solid fa-angle-up\"></i>";
                var elements = document.getElementsByClassName("cid-"+id);
                var names = '';
                for(var i = 0; i < elements.length; i++) {
                    document.getElementById(elements[i].id).classList.remove('hidden');
                    document.getElementById(elements[i].id).classList.add('block');
                }
                console.log(names);
            }

            function HideChild(id) {
                document.getElementById("dropdown-"+id).href = "javascript:ShowChild("+id+");";
                document.getElementById("dropdown-"+id).innerHTML = "<i class=\"fa-solid fa-angle-down\"></i>";
                var elements = document.getElementsByClassName("cid-"+id);
                var names = '';
                for(var i = 0; i < elements.length; i++) {
                    document.getElementById(elements[i].id).classList.remove('block');
                    document.getElementById(elements[i].id).classList.add('hidden');
                }
                console.log(names);
            }

            var List = document.getElementById("PageList").innerHTML;

            fetch('<?= $API_LOCATION; ?>/<?= API_VERSION; ?>/page/list')
                .then(response=>response.text())
                .then(data=>{
                    const JSONData = JSON.parse(data);
                    for(var i in JSONData) {
                        let ml = 8 * JSONData[i].parentcount;
                        let emptyAlert = '';
                        if (JSONData[i].content == null) {
                            emptyAlert = `<div class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white" title="<?= $TL->TL('Page_Empty'); ?>">
                                <i class="fas fa-triangle-exclamation" aria-hidden="true"></i>
                                <span class="flex-1 ml-3 whitespace-nowrap lg:block md:hidden sm:block hidden"><?= $TL->TL('Page_Empty'); ?></span>
                            </div>`;
                        }
                        let state = 'block';
                        let dropdownIcon = '';
                        if (JSONData[i].parent != null) {
                            state = 'hidden';
                            dropdownIcon = '<p class="inline self-center mx-3"><i class="fas fa-turn-up rotate-90" aria-hidden="true"></i></p>';
                        }
                        let dropdownButton = `<div id="dropdown-`+JSONData[i].id+`" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800 invisible">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>`;
                        if (JSONData[i].isparent === true) {
                            dropdownButton = `<a id="dropdown-`+JSONData[i].id+`" href="javascript:ShowChild(`+JSONData[i].id+`)" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                            <i class="fa-solid fa-angle-down"></i>
                        </a>`
                        }
                        List = List + `<div class="`+state+` cid-`+JSONData[i].parent+` flex ml-`+(ml-8)+`" id="`+JSONData[i].id+`">` + dropdownIcon + `<div class="flex-grow px-3 py-2 my-1 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                        <a href="/panel/pages/edit/?id=`+JSONData[i].id+`" class="flex-grow self-center flex">
                            <p class="flex-grow self-center">`+JSONData[i].title+`</p>`+emptyAlert+`
                        </a>
                        <a href="/panel/pages/edit/?id=`+JSONData[i].id+`" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                            <i class="fas fa-pencil" aria-hidden="true"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap lg:block md:hidden sm:block hidden"><?= $TL->TL('Edit'); ?></span>
                        </a>
                        <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                            <i class="fas fa-trash-can" aria-hidden="true"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap lg:block md:hidden sm:block hidden"><?= $TL->TL('Delete'); ?></span>
                        </a>
                        `+dropdownButton+`
                    </div></div>`;
                    }
                    console.log(JSONData);
                    document.getElementById("PageList").innerHTML = List;
                })


        </script>
    </body>
</html>