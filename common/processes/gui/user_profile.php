<?php

    function display_user_profile_picture($value)
    {
        echo '
                                                                        <a href="'.get_user_profile_link($value).'" class="block relative">
                                                                            <img alt="'.get_user_fullname($value).'" src="'.get_user_profilephoto($value).'" class="mx-auto object-cover rounded-full h-16 w-16 "/>
                                                                        </a>';
    }

    function display_user_dropdown($type)
    {
        $return = '<select name="users" class="w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 dark:bg-neutral-800 border rounded-lg appearance-none focus:shadow-outline">';
        $i = 1;
        $user = get_user_username($i);

        while ($user != null && $user != '') {
            if ($type == 'SELECTME' && $i == $_SESSION['id']) {
                $return = $return.'<option value="'.$i.'" selected>'.get_user_fullname($i).'</option>';
            } else {
                $return = $return.'<option value="'.$i.'">'.get_user_fullname($i).'</option>';
            }
            $i = $i + 1;
            $user = get_user_username($i);
        }

        return $return.'</select>';
    }
