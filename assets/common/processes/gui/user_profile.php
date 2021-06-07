<?php
    function display_user_profile_picture($value) {
        echo '
                                                                        <a href="'.get_user_profile_link($value).'" class="block relative">
                                                                            <img alt="'.get_user_fullname($value).'" src="'.get_user_profilephoto($value).'" class="mx-auto object-cover rounded-full h-16 w-16 "/>
                                                                        </a>';
    }