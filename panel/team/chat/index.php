<?php session_start();
    include_once(__DIR__.'/../../../assets/common/global_private.php');
    if(isset($_POST['message'])) {
        $query = "SET time_zone='".CONFIG_TIMEZONE."';";
        $rs = mysqli_query($conn,$query);

        $message = $_POST['message'];
        $message = str_replace('"', "&quot;", $message);
        $query = "INSERT INTO `".DATABASE_PREFIX."` (`id`, `user_id`, `chat_id`, `status`, `message`, `datetime`) VALUES (NULL, '$id', '1', 'ACTIVE', '$message', CURRENT_TIMESTAMP);";
        $rs = mysqli_query($conn,$query);
        header('Location: http://'.htmlspecialchars($_SERVER[HTTP_HOST]).htmlspecialchars($_SERVER[REQUEST_URI]).'');
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
        include_once(__DIR__.'/../../../assets/common/panel/theme.php');
        ?>

        <title>Saturn Panel</title>
    </head>
    <body>
        <?php include_once(__DIR__.'/../../../assets/common/panel/navigation.php'); ?>

        <div class="w-screen">
            <div class="grid grid-cols-3 min-w-full border rounded" style="min-height: 80vh;">
                <div class="col-span-1 bg-white border-r border-gray-300" x-data="loadChats()">

                    <div class="container pt-8 mx-auto" x-data="loadChats()">
                        <div class="my-3 mx-3 ">
                            <div class="relative text-gray-600 focus-within:text-gray-400">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-gray-500"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input
                                    x-ref="searchField"
                                    x-model="search"
                                    x-on:keydown.window.prevent.slash="$refs.searchField.focus()"
                                    placeholder="Search"
                                    type="search"
                                    class="py-2 pl-10 block w-full rounded bg-gray-100 outline-none focus:text-gray-700"
                                />
                            </div>
                        </div>
                            <template x-for="item in filteredChats" :key="item">

                                <a class="hover:bg-gray-100 border-b border-gray-300 px-3 py-2 cursor-pointer flex items-center text-sm focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div class="rounded-full bg-<?php echo THEME_PANEL_COLOUR; ?>-200 px-1 py-1">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                             src="<?php echo CONFIG_INSTALL_URL;?>/assets/panel/images/icon/chat.png"
                                             alt=""
                                        />
                                    </div>
                                    <div class="w-full pb-2">
                                        <div class="flex justify-between">
                                            <span class="block ml-2 font-semibold text-base text-gray-600" x-text="item.chat_name"></span>
                                            <?php
                                                $query = "SELECT * FROM `".DATABASE_PREFIX."chats_messages` WHERE `chat_id` = '1' ORDER BY `id` DESC";
                                                $rs = mysqli_query($conn,$query);
                                                $row = mysqli_fetch_assoc($rs);
                                                echo '<span class="block ml-2 text-sm text-gray-600">Last Message: '.$row['datetime'].'</span>';
                                            ?>
                                        </div>
                                        <span class="block ml-2 text-sm text-gray-600"></span>
                                    </div>
                                </a>
                            </template>
                    </div>
                    <script>
                        function loadChats() {
                            return {
                                search: "",
                                myForData: sourceData,
                                get filteredChats() {
                                    if (this.search === "") {
                                        return this.myForData;
                                    }
                                    return this.myForData.filter((item) => {
                                        return item.chat_name
                                            .toLowerCase()
                                            .includes(this.search.toLowerCase());
                                    });
                                },
                            };
                        }

                        var sourceData = [
                            {
                                id: "1",
                                chat_name: "General",
                            },
                        ];
                    </script>
                </div>
                <div class="col-span-2 bg-white">
                    <div class="w-full">
                        <div class="flex items-center border-b border-gray-300 pl-3 py-3">
                            <div class="rounded-full bg-<?php echo THEME_PANEL_COLOUR; ?>-200 px-1 py-1">
                                <img class="h-8 w-8 rounded-full object-cover"
                                     src="<?php echo CONFIG_INSTALL_URL;?>/assets/panel/images/icon/chat.png"
                                     alt=""
                                />
                            </div>
                            <span class="block ml-2 font-bold text-base text-gray-600">General</span>
                        </div>
                        <div id="chat" class="w-full overflow-y-scroll p-10 relative" style="height: 700px;" ref="toolbarChat">
                            <ul>
                                    <?php
                                    $query = "SELECT * FROM `".DATABASE_PREFIX."chats_messages` WHERE `chat_id` = '1' ORDER BY `id` ASC";
                                    $rs = mysqli_query($conn,$query);
                                    $i = 0;
                                    while($row = mysqli_fetch_assoc($rs)){
                                        $i++;
                                        if ($row['status'] == 'ACTIVE') {
                                            if($row['user_id']==$_SESSION['id']) {
                                                echo '
                                    <li class="w-full flex justify-end">
                                        <div class="flex bg-gray-100 rounded px-5 py-2 my-2 text-gray-700 relative" css="max-width: 300px;">
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="'.CONFIG_INSTALL_URL.'/assets/panel/images/icon/chat.png"
                                                alt="'.get_user_fullname($row['user_id']).'"
                                            />
                                            <div class="ml-2">
                                                <span class="block">'.$row['message'] .'</span>
                                                <span class="block text-xs text-right">'.$row['datetime'] .'</span>
                                            </div>
                                        </div>
                                    </li>';
                                            } else {
                                                echo '
                                    <li class="w-full flex justify-start">
                                        <div class="flex bg-gray-100 rounded px-5 py-2 my-2 text-gray-700 relative" css="max-width: 300px;">
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="'.CONFIG_INSTALL_URL.'/assets/panel/images/icon/chat.png"
                                                alt="'.get_user_fullname($row['user_id']).'"
                                            />
                                            <div class="ml-2">
                                                <span class="block">'.$row['message'] .'</span>
                                                <span class="block text-xs text-right">'.get_user_fullname($row['user_id']).' '.$row['datetime'] .'</span>
                                            </div>
                                        </div>
                                    </li>';
                                            }
                                        }
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>

                        <form method="POST" action="" class="w-full py-3 px-3 flex items-center justify-between border-t border-gray-300">
                            <button onClick="Javascript:alert('Coming soon.');" class="outline-none focus:outline-none">
                                <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                            <button onClick="Javascript:alert('Coming soon.');" class="outline-none focus:outline-none ml-1">
                                <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </button>
                            <input
                                id="message"
                                name="message"
                                type="text"
                                aria-placeholder="Message"
                                placeholder="Message"
                                required
                                class="py-2 mx-3 pl-5 block w-full rounded-full bg-gray-100 outline-none focus:text-gray-700"
                            />
                            <button class="outline-none focus:outline-none" type="submit">
                                <svg class="text-gray-400 h-7 w-7 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script>
            $("#chat").scrollTop($("#chat")[0].scrollHeight);
        </script>
    </body>
</html>
