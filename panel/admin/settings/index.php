<?php
session_start();

require_once __DIR__.'/../../../assets/common/global_private.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__ . '/../../../assets/common/panel/vendors.php'; ?>

        <title><?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../../assets/common/panel/theme.php'; ?>
    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../assets/common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <div class="grid grid-cols-2">
                <h1 class="text-gray-900 text-3xl">Settings</h1>
                <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-save" aria-hidden="true"></i>
                    </span>
                    Save
                </button>
            </div>
            <form class="mt-8 space-y-6 w-full" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">General</h2>
                    <div class="grid grid-cols-2">
                        <label for="site_name">Site Name</label>
                        <input id="site_name" name="site_name" type="text" value="<?php echo CONFIG_SITE_NAME; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_description">Site Description</label>
                        <input id="site_description" name="site_description" type="text" value="<?php echo CONFIG_SITE_DESCRIPTION; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_keywords">Site Keywords</label>
                        <input id="site_keywords" name="site_keywords" type="text" value="<?php echo CONFIG_SITE_KEYWORDS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_charset">Site Charset</label>
                        <select id="site_charset" name="site_charset" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option disabled>UTF</option>
                            <option value="utf-8">UTF-8</option>
                            <option value="utf-8" selected>UTF-8 (utf8mb4) (Recommended)</option>
                            <option value="utf-16">UTF-16</option>
                            <option value="utf-32">UTF-32</option>
                            <option disabled>Others</option>
                            <option value="ascii">US ASCII</option>
                            <option value="unicode">Unicode (ucs2)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_timezone">Site Timezone</label>
                        <select id="site_timezone" name="site_timezone" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option disabled>---------- Africa ----------</option>
                            <option value="Africa/Abidjan"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Abidjan'){echo ' selected';}?>>Africa/Abidjan</option>
                            <option value="Africa/Accra"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Accra'){echo ' selected';}?>>Africa/Accra</option>
                            <option value="Africa/Addis_Ababa"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Addis_Ababa'){echo ' selected';}?>>Africa/Addis_Ababa</option>
                            <option value="Africa/Algiers"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Algiers'){echo ' selected';}?>>Africa/Algiers</option>
                            <option value=Africa/Asmara""<?php if(CONFIG_SITE_TIMEZONE=='Africa/Asmara'){echo ' selected';}?>>Africa/Asmara</option>
                            <option value="Africa/Bamako"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Bamako'){echo ' selected';}?>>Africa/Bamako</option>
                            <option value="Africa/Bangui"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Bangui'){echo ' selected';}?>>Africa/Bangui</option>
                            <option value="Africa/Banjul"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Banjul'){echo ' selected';}?>>Africa/Banjul</option>
                            <option value="Africa/Bissau"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Bissau'){echo ' selected';}?>>Africa/Bissau</option>
                            <option value="Africa/Blantyre"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Blantyre'){echo ' selected';}?>>Africa/Blantyre</option>
                            <option value="Africa/Brazzaville"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Brazzaville'){echo ' selected';}?>>Africa/Brazzaville</option>
                            <option value="Africa/Bujumbura"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Bujumbura'){echo ' selected';}?>>Africa/Bujumbura</option>
                            <option value="Africa/Cairo"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Cairo'){echo ' selected';}?>>Africa/Cairo</option>
                            <option value="Africa/Casablanca"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Casablanca'){echo ' selected';}?>>Africa/Casablanca</option>
                            <option value="Africa/Ceuta"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Ceuta'){echo ' selected';}?>>Africa/Ceuta</option>
                            <option value="Africa/Conakry"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Conakry'){echo ' selected';}?>>Africa/Conakry</option>
                            <option value="Africa/Dakar"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Dakar'){echo ' selected';}?>>Africa/Dakar</option>
                            <option value="Africa/Dar_es_Salaam"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Dar_es_Salaam'){echo ' selected';}?>>Africa/Dar_es_Salaam</option>
                            <option value="Africa/Djibouti"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Djibouti'){echo ' selected';}?>>Africa/Djibouti</option>
                            <option value="Africa/Douala"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Douala'){echo ' selected';}?>>Africa/Douala</option>
                            <option value="Africa/El_Aaiun"<?php if(CONFIG_SITE_TIMEZONE=='Africa/El_Aaiun'){echo ' selected';}?>>Africa/El_Aaiun</option>
                            <option value="Africa/Freetown"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Freetown'){echo ' selected';}?>>Africa/Freetown</option>
                            <option value="Africa/Gaborone"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Gaborone'){echo ' selected';}?>>Africa/Gaborone</option>
                            <option value="Africa/Harare"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Harare'){echo ' selected';}?>>Africa/Harare</option>
                            <option value="Africa/Johannesburg"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Johannesburg'){echo ' selected';}?>>Africa/Johannesburg</option>
                            <option value="Africa/Juba"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Juba'){echo ' selected';}?>>Africa/Juba</option>
                            <option value="Africa/Kampala"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Kampala'){echo ' selected';}?>>Africa/Kampala</option>
                            <option value="Africa/Khartoum"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Khartoum'){echo ' selected';}?>>Africa/Khartoum</option>
                            <option value="Africa/Kigali"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Kigali'){echo ' selected';}?>>Africa/Kigali</option>
                            <option value="Africa/Kinshasa"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Kinshasa'){echo ' selected';}?>>Africa/Kinshasa</option>
                            <option value="Africa/Lagos"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Lagos'){echo ' selected';}?>>Africa/Lagos</option>
                            <option value="Africa/Libreville"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Libreville'){echo ' selected';}?>>Africa/Libreville</option>
                            <option value="Africa/Lome"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Lome'){echo ' selected';}?>>Africa/Lome</option>
                            <option value="Africa/Luanda"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Luanda'){echo ' selected';}?>>Africa/Luanda</option>
                            <option value="Africa/Lubumbashi"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Lubumbashi'){echo ' selected';}?>>Africa/Lubumbashi</option>
                            <option value="Africa/Lusaka"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Lusaka'){echo ' selected';}?>>Africa/Lusaka</option>
                            <option value="Africa/Malabo"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Malabo'){echo ' selected';}?>>Africa/Malabo</option>
                            <option value="Africa/Maputo"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Maputo'){echo ' selected';}?>>Africa/Maputo</option>
                            <option value="Africa/Maseru"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Maseru'){echo ' selected';}?>>Africa/Maseru</option>
                            <option value="Africa/Mbabane"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Mbabane'){echo ' selected';}?>>Africa/Mbabane</option>
                            <option value="Africa/Mogadishu"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Mogadishu'){echo ' selected';}?>>Africa/Mogadishu</option>
                            <option value="Africa/Monrovia"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Monrovia'){echo ' selected';}?>>Africa/Monrovia</option>
                            <option value="Africa/Nairobi"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Nairobi'){echo ' selected';}?>>Africa/Nairobi</option>
                            <option value="Africa/Ndjamena"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Ndjamena'){echo ' selected';}?>>Africa/Ndjamena</option>
                            <option value="Africa/Niamey"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Niamey'){echo ' selected';}?>>Africa/Niamey</option>
                            <option value="Africa/Nouakchott"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Nouakchott'){echo ' selected';}?>>Africa/Nouakchott</option>
                            <option value="Africa/Ouagadougou"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Ouagadougou'){echo ' selected';}?>>Africa/Ouagadougou</option>
                            <option value="Africa/Porto-Novo"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Porto-Novo'){echo ' selected';}?>>Africa/Porto-Novo</option>
                            <option value="Africa/Sao_Tome"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Sao_Tome'){echo ' selected';}?>>Africa/Sao_Tome</option>
                            <option value="Africa/Tripoli"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Tripoli'){echo ' selected';}?>>Africa/Tripoli</option>
                            <option value="Africa/Tunis"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Tunis'){echo ' selected';}?>>Africa/Tunis</option>
                            <option value="Africa/Windhoek"<?php if(CONFIG_SITE_TIMEZONE=='Africa/Windhoek'){echo ' selected';}?>>Africa/Windhoek</option>

                            <option disabled>---------- America ----------</option>
                            <option value="America/Adak"<?php if(CONFIG_SITE_TIMEZONE=='America/Adak'){echo ' selected';}?>>America/Adak</option>
                            <option value="America/Anchorage"<?php if(CONFIG_SITE_TIMEZONE=='America/Anchorage'){echo ' selected';}?>>America/Anchorage</option>
                            <option value="America/Anguilla"<?php if(CONFIG_SITE_TIMEZONE=='America/Anguilla'){echo ' selected';}?>>America/Anguilla</option>
                            <option value="America/Antigua"<?php if(CONFIG_SITE_TIMEZONE=='America/Antigua'){echo ' selected';}?>>America/Antigua</option>
                            <option value="America/Araguaina"<?php if(CONFIG_SITE_TIMEZONE=='America/Araguaina'){echo ' selected';}?>>America/Araguaina</option>
                            <option value="America/Argentina/Buenos_Aires"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Buenos_Aires'){echo ' selected';}?>>America/Argentina/Buenos_Aires</option>
                            <option value="America/Argentina/Catamarca"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Catamarca'){echo ' selected';}?>>America/Argentina/Catamarca</option>
                            <option value="America/Argentina/Cordoba"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Cordoba'){echo ' selected';}?>>America/Argentina/Cordoba</option>
                            <option value="America/Argentina/Jujuy"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Jujuy'){echo ' selected';}?>>America/Argentina/Jujuy</option>
                            <option value="America/Argentina/La_Rioja"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/La_Rioja'){echo ' selected';}?>>America/Argentina/La_Rioja</option>
                            <option value="America/Argentina/Mendoza"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Mendoza'){echo ' selected';}?>>America/Argentina/Mendoza</option>
                            <option value="America/Argentina/Rio_Gallegos"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Rio_Gallegos'){echo ' selected';}?>>America/Argentina/Rio_Gallegos</option>
                            <option value="America/Argentina/Salta"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Salta'){echo ' selected';}?>>America/Argentina/Salta</option>
                            <option value="America/Argentina/San_Juan"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/San_Juan'){echo ' selected';}?>>America/Argentina/San_Juan</option>
                            <option value="America/Argentina/San_Luis"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/San_Luis'){echo ' selected';}?>>America/Argentina/San_Luis</option>
                            <option value="America/Argentina/Tucuman"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Tucuman'){echo ' selected';}?>>America/Argentina/Tucuman</option>
                            <option value="America/Argentina/Ushuaia"<?php if(CONFIG_SITE_TIMEZONE=='America/Argentina/Ushuaia'){echo ' selected';}?>>America/Argentina/Ushuaia</option>
                            <option value="America/Aruba"<?php if(CONFIG_SITE_TIMEZONE=='America/Aruba'){echo ' selected';}?>>America/Aruba</option>
                            <option value="America/Asuncion"<?php if(CONFIG_SITE_TIMEZONE=='America/Asuncion'){echo ' selected';}?>>America/Asuncion</option>
                            <option value="America/Atikokan"<?php if(CONFIG_SITE_TIMEZONE=='America/Atikokan'){echo ' selected';}?>>America/Atikokan</option>
                            <option value="America/Bahia"<?php if(CONFIG_SITE_TIMEZONE=='America/Bahia'){echo ' selected';}?>>America/Bahia</option>
                            <option value="America/Bahia_Banderas"<?php if(CONFIG_SITE_TIMEZONE=='America/Bahia_Banderas'){echo ' selected';}?>>America/Bahia_Banderas</option>
                            <option value="America/Barbados"<?php if(CONFIG_SITE_TIMEZONE=='America/Barbados'){echo ' selected';}?>>America/Barbados</option>
                            <option value="America/Belem"<?php if(CONFIG_SITE_TIMEZONE=='America/Belem'){echo ' selected';}?>>America/Belem</option>
                            <option value="America/Belize"<?php if(CONFIG_SITE_TIMEZONE=='America/Belize'){echo ' selected';}?>>America/Belize</option>
                            <option value="America/Blanc-Sablon"<?php if(CONFIG_SITE_TIMEZONE=='America/Blanc-Sablon'){echo ' selected';}?>>America/Blanc-Sablon</option>
                            <option value="America/Boa_Vista"<?php if(CONFIG_SITE_TIMEZONE=='America/Boa_Vista'){echo ' selected';}?>>America/Boa_Vista</option>
                            <option value="America/Bogota"<?php if(CONFIG_SITE_TIMEZONE=='America/Bogota'){echo ' selected';}?>>America/Bogota</option>
                            <option value="America/Boise"<?php if(CONFIG_SITE_TIMEZONE=='America/Boise'){echo ' selected';}?>>America/Boise</option>
                            <option value="America/Cambridge_Bay"<?php if(CONFIG_SITE_TIMEZONE=='America/Cambridge_Bay'){echo ' selected';}?>>America/Cambridge_Bay</option>
                            <option value="America/Campo_Grande"<?php if(CONFIG_SITE_TIMEZONE=='America/Campo_Grande'){echo ' selected';}?>>America/Campo_Grande</option>
                            <option value="America/Cancun"<?php if(CONFIG_SITE_TIMEZONE=='America/Cancun'){echo ' selected';}?>>America/Cancun</option>
                            <option value="America/Caracas"<?php if(CONFIG_SITE_TIMEZONE=='America/Caracas'){echo ' selected';}?>>America/Caracas</option>
                            <option value="America/Cayenne"<?php if(CONFIG_SITE_TIMEZONE=='America/Cayenne'){echo ' selected';}?>>America/Cayenne</option>
                            <option value="America/Cayman"<?php if(CONFIG_SITE_TIMEZONE=='America/Cayman'){echo ' selected';}?>>America/Cayman</option>
                            <option value="America/Chicago"<?php if(CONFIG_SITE_TIMEZONE=='America/Chicago'){echo ' selected';}?>>America/Chicago</option>
                            <option value="America/Chihuahua"<?php if(CONFIG_SITE_TIMEZONE=='America/Chihuahua'){echo ' selected';}?>>America/Chihuahua</option>
                            <option value="America/Costa_Rica"<?php if(CONFIG_SITE_TIMEZONE=='America/Costa_Rica'){echo ' selected';}?>>America/Costa_Rica</option>
                            <option value="America/Creston"<?php if(CONFIG_SITE_TIMEZONE=='America/Creston'){echo ' selected';}?>>America/Creston</option>
                            <option value="America/Cuiaba"<?php if(CONFIG_SITE_TIMEZONE=='America/Cuiaba'){echo ' selected';}?>>America/Cuiaba</option>
                            <option value="America/Curacao"<?php if(CONFIG_SITE_TIMEZONE=='America/Curacao'){echo ' selected';}?>>America/Curacao</option>
                            <option value="America/Danmarkshavn"<?php if(CONFIG_SITE_TIMEZONE=='America/Danmarkshavn'){echo ' selected';}?>>America/Danmarkshavn</option>
                            <option value="America/Dawson"<?php if(CONFIG_SITE_TIMEZONE=='America/Dawson'){echo ' selected';}?>>America/Dawson</option>
                            <option value="America/Dawson_Creek"<?php if(CONFIG_SITE_TIMEZONE=='America/Dawson_Creek'){echo ' selected';}?>>America/Dawson_Creek</option>
                            <option value="America/Denver"<?php if(CONFIG_SITE_TIMEZONE=='America/Denver'){echo ' selected';}?>>America/Denver</option>
                            <option value="America/Detroit"<?php if(CONFIG_SITE_TIMEZONE=='America/Detroit'){echo ' selected';}?>>America/Detroit</option>
                            <option value="America/Dominica"<?php if(CONFIG_SITE_TIMEZONE=='America/Dominica'){echo ' selected';}?>>America/Dominica</option>
                            <option value="America/Edmonton"<?php if(CONFIG_SITE_TIMEZONE=='America/Edmonton'){echo ' selected';}?>>America/Edmonton</option>
                            <option value="America/Eirunepe"<?php if(CONFIG_SITE_TIMEZONE=='America/Eirunepe'){echo ' selected';}?>>America/Eirunepe</option>
                            <option value="America/El_Salvador"<?php if(CONFIG_SITE_TIMEZONE=='America/El_Salvador'){echo ' selected';}?>>America/El_Salvador</option>
                            <option value="America/Fort_Nelson"<?php if(CONFIG_SITE_TIMEZONE=='America/Fort_Nelson'){echo ' selected';}?>>America/Fort_Nelson</option>
                            <option value="America/Fortaleza"<?php if(CONFIG_SITE_TIMEZONE=='America/Fortaleza'){echo ' selected';}?>>America/Fortaleza</option>
                            <option value="America/Glace_Bay"<?php if(CONFIG_SITE_TIMEZONE=='America/Glace_Bay'){echo ' selected';}?>>America/Glace_Bay</option>
                            <option value="America/Goose_Bay"<?php if(CONFIG_SITE_TIMEZONE=='America/Goose_Bay'){echo ' selected';}?>>America/Goose_Bay</option>
                            <option value="America/Grand_Turk"<?php if(CONFIG_SITE_TIMEZONE=='America/Grand_Turk'){echo ' selected';}?>>America/Grand_Turk</option>
                            <option value="America/Grenada"<?php if(CONFIG_SITE_TIMEZONE=='America/Grenada'){echo ' selected';}?>>America/Grenada</option>
                            <option value="America/Guadeloupe"<?php if(CONFIG_SITE_TIMEZONE=='America/Guadeloupe'){echo ' selected';}?>>America/Guadeloupe</option>
                            <option value="America/Guatemala"<?php if(CONFIG_SITE_TIMEZONE=='America/Guatemala'){echo ' selected';}?>>America/Guatemala</option>
                            <option value="America/Guayaquil"<?php if(CONFIG_SITE_TIMEZONE=='America/Guayaquil'){echo ' selected';}?>>America/Guayaquil</option>
                            <option value="America/Guyana"<?php if(CONFIG_SITE_TIMEZONE=='America/Guyana'){echo ' selected';}?>>America/Guyana</option>
                            <option value="America/Halifax"<?php if(CONFIG_SITE_TIMEZONE=='America/Halifax'){echo ' selected';}?>>America/Halifax</option>
                            <option value="America/Havana"<?php if(CONFIG_SITE_TIMEZONE=='America/Havana'){echo ' selected';}?>>America/Havana</option>
                            <option value="America/Hermosillo"<?php if(CONFIG_SITE_TIMEZONE=='America/Hermosillo'){echo ' selected';}?>>America/Hermosillo</option>
                            <option value="America/Indiana/Indianapolis"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Indianapolis'){echo ' selected';}?>>America/Indiana/Indianapolis</option>
                            <option value="America/Indiana/Knox"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Knox'){echo ' selected';}?>>America/Indiana/Knox</option>
                            <option value="America/Indiana/Marengo"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Marengo'){echo ' selected';}?>>America/Indiana/Marengo</option>
                            <option value="America/Indiana/Petersburg"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Petersburg'){echo ' selected';}?>>America/Indiana/Petersburg</option>
                            <option value="America/Indiana/Tell_City"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Tell_City'){echo ' selected';}?>>America/Indiana/Tell_City</option>
                            <option value="America/Indiana/Vevay"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Vevay'){echo ' selected';}?>>America/Indiana/Vevay</option>
                            <option value="America/Indiana/Vincennes"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Vincennes'){echo ' selected';}?>>America/Indiana/Vincennes</option>
                            <option value="America/Indiana/Winamac"<?php if(CONFIG_SITE_TIMEZONE=='America/Indiana/Winamac'){echo ' selected';}?>>America/Indiana/Winamac</option>
                            <option value="America/Inuvik"<?php if(CONFIG_SITE_TIMEZONE=='America/Inuvik'){echo ' selected';}?>>America/Inuvik</option>
                            <option value="America/Iqaluit"<?php if(CONFIG_SITE_TIMEZONE=='America/Iqaluit'){echo ' selected';}?>>America/Iqaluit</option>
                            <option value="America/Jamaica"<?php if(CONFIG_SITE_TIMEZONE=='America/Jamaica'){echo ' selected';}?>>America/Jamaica</option>
                            <option value="America/Juneau"<?php if(CONFIG_SITE_TIMEZONE=='America/Juneau'){echo ' selected';}?>>America/Juneau</option>
                            <option value="America/Kentucky/Louisville"<?php if(CONFIG_SITE_TIMEZONE=='America/Kentucky/Louisville'){echo ' selected';}?>>America/Kentucky/Louisville</option>
                            <option value="America/Kentucky/Monticello"<?php if(CONFIG_SITE_TIMEZONE=='America/Kentucky/Monticello'){echo ' selected';}?>>America/Kentucky/Monticello</option>
                            <option value="America/Kralendijk"<?php if(CONFIG_SITE_TIMEZONE=='America/Kralendijk'){echo ' selected';}?>>America/Kralendijk</option>
                            <option value="America/La_Paz"<?php if(CONFIG_SITE_TIMEZONE=='America/La_Paz'){echo ' selected';}?>>America/La_Paz</option>
                            <option value="America/Lima"<?php if(CONFIG_SITE_TIMEZONE=='America/Lima'){echo ' selected';}?>>America/Lima</option>
                            <option value="America/Los_Angeles"<?php if(CONFIG_SITE_TIMEZONE=='America/Los_Angeles'){echo ' selected';}?>>America/Los_Angeles</option>
                            <option value="America/Lower_Princes"<?php if(CONFIG_SITE_TIMEZONE=='America/Lower_Princes'){echo ' selected';}?>>America/Lower_Princes</option>
                            <option value="America/Maceio"<?php if(CONFIG_SITE_TIMEZONE=='America/Maceio'){echo ' selected';}?>>America/Maceio</option>
                            <option value="America/Managua"<?php if(CONFIG_SITE_TIMEZONE=='America/Managua'){echo ' selected';}?>>America/Managua</option>
                            <option value="America/Manaus"<?php if(CONFIG_SITE_TIMEZONE=='America/Manaus'){echo ' selected';}?>>America/Manaus</option>
                            <option value="America/Marigot"<?php if(CONFIG_SITE_TIMEZONE=='America/Marigot'){echo ' selected';}?>>America/Marigot</option>
                            <option value="America/Martinique"<?php if(CONFIG_SITE_TIMEZONE=='America/Martinique'){echo ' selected';}?>>America/Martinique</option>
                            <option value="America/Matamoros"<?php if(CONFIG_SITE_TIMEZONE=='America/Matamoros'){echo ' selected';}?>>America/Matamoros</option>
                            <option value="America/Mazatlan"<?php if(CONFIG_SITE_TIMEZONE=='America/Mazatlan'){echo ' selected';}?>>America/Mazatlan</option>
                            <option value="America/Menominee"<?php if(CONFIG_SITE_TIMEZONE=='America/Menominee'){echo ' selected';}?>>America/Menominee</option>
                            <option value="America/Merida"<?php if(CONFIG_SITE_TIMEZONE=='America/Merida'){echo ' selected';}?>>America/Merida</option>
                            <option value="America/Metlakatla"<?php if(CONFIG_SITE_TIMEZONE=='America/Metlakatla'){echo ' selected';}?>>America/Metlakatla</option>
                            <option value="America/Mexico_City"<?php if(CONFIG_SITE_TIMEZONE=='America/Mexico_City'){echo ' selected';}?>>America/Mexico_City</option>
                            <option value="America/Miquelon"<?php if(CONFIG_SITE_TIMEZONE=='America/Miquelon'){echo ' selected';}?>>America/Miquelon</option>
                            <option value="America/Moncton"<?php if(CONFIG_SITE_TIMEZONE=='America/Moncton'){echo ' selected';}?>>America/Moncton</option>
                            <option value="America/Monterrey"<?php if(CONFIG_SITE_TIMEZONE=='America/Monterrey'){echo ' selected';}?>>America/Monterrey</option>
                            <option value="America/Montevideo"<?php if(CONFIG_SITE_TIMEZONE=='America/Montevideo'){echo ' selected';}?>>America/Montevideo</option>
                            <option value="America/Montserrat"<?php if(CONFIG_SITE_TIMEZONE=='America/Montserrat'){echo ' selected';}?>>America/Montserrat</option>
                            <option value="America/Nassau"<?php if(CONFIG_SITE_TIMEZONE=='America/Nassau'){echo ' selected';}?>>America/Nassau</option>
                            <option value="America/New_York"<?php if(CONFIG_SITE_TIMEZONE=='America/New_York'){echo ' selected';}?>>America/New_York</option>
                            <option value="America/Nipigon"<?php if(CONFIG_SITE_TIMEZONE=='America/Nipigon'){echo ' selected';}?>>America/Nipigon</option>
                            <option value="America/Nome"<?php if(CONFIG_SITE_TIMEZONE=='America/Nome'){echo ' selected';}?>>America/Nome</option>
                            <option value="America/Noronha"<?php if(CONFIG_SITE_TIMEZONE=='America/Noronha'){echo ' selected';}?>>America/Noronha</option>
                            <option value="America/North_Dakota/Beulah"<?php if(CONFIG_SITE_TIMEZONE=='America/North_Dakota/Beulah'){echo ' selected';}?>>America/North_Dakota/Beulah</option>
                            <option value="America/North_Dakota/Center"<?php if(CONFIG_SITE_TIMEZONE=='America/North_Dakota/Center'){echo ' selected';}?>>America/North_Dakota/Center</option>
                            <option value="America/North_Dakota/New_Salem"<?php if(CONFIG_SITE_TIMEZONE=='America/North_Dakota/New_Salem'){echo ' selected';}?>>America/North_Dakota/New_Salem</option>
                            <option value="America/Nuuk"<?php if(CONFIG_SITE_TIMEZONE=='America/Nuuk'){echo ' selected';}?>>America/Nuuk</option>
                            <option value="America/Ojinaga"<?php if(CONFIG_SITE_TIMEZONE=='America/Ojinaga'){echo ' selected';}?>>America/Ojinaga</option>
                            <option value="America/Panama"<?php if(CONFIG_SITE_TIMEZONE=='America/Panama'){echo ' selected';}?>>America/Panama</option>
                            <option value="America/Pangnirtung"<?php if(CONFIG_SITE_TIMEZONE=='America/Pangnirtung'){echo ' selected';}?>>America/Pangnirtung</option>
                            <option value="America/Paramaribo"<?php if(CONFIG_SITE_TIMEZONE=='America/Paramaribo'){echo ' selected';}?>>America/Paramaribo</option>
                            <option value="America/Phoenix"<?php if(CONFIG_SITE_TIMEZONE=='America/Phoenix'){echo ' selected';}?>>America/Phoenix</option>
                            <option value="America/Port-au-Prince"<?php if(CONFIG_SITE_TIMEZONE=='America/Port-au-Prince'){echo ' selected';}?>>America/Port-au-Prince</option>
                            <option value="America/Port_of_Spain"<?php if(CONFIG_SITE_TIMEZONE=='America/Port_of_Spain'){echo ' selected';}?>>America/Port_of_Spain</option>
                            <option value="America/Porto_Velho"<?php if(CONFIG_SITE_TIMEZONE=='America/Porto_Velho'){echo ' selected';}?>>America/Porto_Velho</option>
                            <option value="America/Puerto_Rico"<?php if(CONFIG_SITE_TIMEZONE=='America/Puerto_Rico'){echo ' selected';}?>>America/Puerto_Rico</option>
                            <option value="America/Punta_Arenas"<?php if(CONFIG_SITE_TIMEZONE=='America/Punta_Arenas'){echo ' selected';}?>>America/Punta_Arenas</option>
                            <option value="America/Rainy_River"<?php if(CONFIG_SITE_TIMEZONE=='America/Rainy_River'){echo ' selected';}?>>America/Rainy_River</option>
                            <option value="America/Rankin_Inlet"<?php if(CONFIG_SITE_TIMEZONE=='America/Rankin_Inlet'){echo ' selected';}?>>America/Rankin_Inlet</option>
                            <option value="America/Recife"<?php if(CONFIG_SITE_TIMEZONE=='America/Recife'){echo ' selected';}?>>America/Recife</option>
                            <option value="America/Regina"<?php if(CONFIG_SITE_TIMEZONE=='America/Regina'){echo ' selected';}?>>America/Regina</option>
                            <option value="America/Resolute"<?php if(CONFIG_SITE_TIMEZONE=='America/Resolute'){echo ' selected';}?>>America/Resolute</option>
                            <option value="America/Rio_Branco"<?php if(CONFIG_SITE_TIMEZONE=='America/Rio_Branco'){echo ' selected';}?>>America/Rio_Branco</option>
                            <option value="America/Santarem"<?php if(CONFIG_SITE_TIMEZONE=='America/Santarem'){echo ' selected';}?>>America/Santarem</option>
                            <option value="America/Santiago"<?php if(CONFIG_SITE_TIMEZONE=='America/Santiago'){echo ' selected';}?>>America/Santiago</option>
                            <option value="America/Santo_Domingo"<?php if(CONFIG_SITE_TIMEZONE=='America/Santo_Domingo'){echo ' selected';}?>>America/Santo_Domingo</option>
                            <option value="America/Sao_Paulo"<?php if(CONFIG_SITE_TIMEZONE=='America/Sao_Paulo'){echo ' selected';}?>>America/Sao_Paulo</option>
                            <option value="America/Scoresbysund"<?php if(CONFIG_SITE_TIMEZONE=='America/Scoresbysund'){echo ' selected';}?>>America/Scoresbysund</option>
                            <option value="America/Sitka"<?php if(CONFIG_SITE_TIMEZONE=='America/Sitka'){echo ' selected';}?>>America/Sitka</option>
                            <option value="America/St_Barthelemy"<?php if(CONFIG_SITE_TIMEZONE=='America/St_Barthelemy'){echo ' selected';}?>>America/St_Barthelemy</option>
                            <option value="America/St_Johns"<?php if(CONFIG_SITE_TIMEZONE=='America/St_Johns'){echo ' selected';}?>>America/St_Johns</option>
                            <option value="America/St_Kitts"<?php if(CONFIG_SITE_TIMEZONE=='America/St_Kitts'){echo ' selected';}?>>America/St_Kitts</option>
                            <option value="America/St_Lucia"<?php if(CONFIG_SITE_TIMEZONE=='America/St_Lucia'){echo ' selected';}?>>America/St_Lucia</option>
                            <option value="America/St_Thomas"<?php if(CONFIG_SITE_TIMEZONE=='America/St_Thomas'){echo ' selected';}?>>America/St_Thomas</option>
                            <option value="America/St_Vincent"<?php if(CONFIG_SITE_TIMEZONE=='America/St_Vincent'){echo ' selected';}?>>America/St_Vincent</option>
                            <option value="America/Swift_Current"<?php if(CONFIG_SITE_TIMEZONE=='America/Swift_Current'){echo ' selected';}?>>America/Swift_Current</option>
                            <option value="America/Tegucigalpa"<?php if(CONFIG_SITE_TIMEZONE=='America/Tegucigalpa'){echo ' selected';}?>>America/Tegucigalpa</option>
                            <option value="America/Thule"<?php if(CONFIG_SITE_TIMEZONE=='America/Thule'){echo ' selected';}?>>America/Thule</option>
                            <option value="America/Thunder_Bay"<?php if(CONFIG_SITE_TIMEZONE=='America/Thunder_Bay'){echo ' selected';}?>>America/Thunder_Bay</option>
                            <option value="America/Tijuana"<?php if(CONFIG_SITE_TIMEZONE=='America/Tijuana'){echo ' selected';}?>>America/Tijuana</option>
                            <option value="America/Toronto"<?php if(CONFIG_SITE_TIMEZONE=='America/Toronto'){echo ' selected';}?>>America/Toronto</option>
                            <option value="America/Tortola"<?php if(CONFIG_SITE_TIMEZONE=='America/Tortola'){echo ' selected';}?>>America/Tortola</option>
                            <option value="America/Vancouver"<?php if(CONFIG_SITE_TIMEZONE=='America/Vancouver'){echo ' selected';}?>>America/Vancouver</option>
                            <option value="America/Whitehorse"<?php if(CONFIG_SITE_TIMEZONE=='America/Whitehorse'){echo ' selected';}?>>America/Whitehorse</option>
                            <option value="America/Winnipeg"<?php if(CONFIG_SITE_TIMEZONE=='America/Winnipeg'){echo ' selected';}?>>America/Winnipeg</option>
                            <option value="America/Yakutat"<?php if(CONFIG_SITE_TIMEZONE=='America/Yakutat'){echo ' selected';}?>>America/Yakutat</option>
                            <option value="America/Yellowknife"<?php if(CONFIG_SITE_TIMEZONE=='America/Yellowknife'){echo ' selected';}?>>America/Yellowknife</option>

                            <option disabled>---------- Antarctica ----------</option>
                            <option value="Antarctica/Casey"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Casey'){echo ' selected';}?>>Antarctica/Casey</option>
                            <option value="Antarctica/Davis"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Davis'){echo ' selected';}?>>Antarctica/Davis</option>
                            <option value="Antarctica/DumontDUrville"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/DumontDUrville'){echo ' selected';}?>>Antarctica/DumontDUrville</option>
                            <option value="Antarctica/Macquarie"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Macquarie'){echo ' selected';}?>>Antarctica/Macquarie</option>
                            <option value="Antarctica/Mawson"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Mawson'){echo ' selected';}?>>Antarctica/Mawson</option>
                            <option value="Antarctica/McMurdo"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/McMurdo'){echo ' selected';}?>>Antarctica/McMurdo</option>
                            <option value="Antarctica/Palmer"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Palmer'){echo ' selected';}?>>Antarctica/Palmer</option>
                            <option value="Antarctica/Rothera"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Rothera'){echo ' selected';}?>>Antarctica/Rothera</option>
                            <option value="Antarctica/Syowa"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Syowa'){echo ' selected';}?>>Antarctica/Syowa</option>
                            <option value="Antarctica/Troll"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Troll'){echo ' selected';}?>>Antarctica/Troll</option>
                            <option value="Antarctica/Vostok"<?php if(CONFIG_SITE_TIMEZONE=='Antarctica/Vostok'){echo ' selected';}?>>Antarctica/Vostok</option>

                            <option disabled>---------- Arctic ----------</option>
                            <option value="Arctic/Longyearbyen"<?php if(CONFIG_SITE_TIMEZONE=='Arctic/Longyearbyen'){echo ' selected';}?>>Arctic/Longyearbyen</option>

                            <option disabled>---------- Asia ----------</option>
                            <option value="Asia/Aden"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Aden'){echo ' selected';}?>>Asia/Aden</option>
                            <option value="Asia/Almaty"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Almaty'){echo ' selected';}?>>Asia/Almaty</option>
                            <option value="Asia/Amman"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Amman'){echo ' selected';}?>>Asia/Amman</option>
                            <option value="Asia/Anadyr"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Anadyr'){echo ' selected';}?>>Asia/Anadyr</option>
                            <option value="Asia/Aqtau"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Aqtau'){echo ' selected';}?>>Asia/Aqtau</option>
                            <option value="Asia/Aqtobe"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Aqtobe'){echo ' selected';}?>>Asia/Aqtobe</option>
                            <option value="Asia/Ashgabat"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Ashgabat'){echo ' selected';}?>>Asia/Ashgabat</option>
                            <option value="Asia/Atyrau"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Atyrau'){echo ' selected';}?>>Asia/Atyrau</option>
                            <option value="Asia/Baghdad"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Baghdad'){echo ' selected';}?>>Asia/Baghdad</option>
                            <option value="Asia/Bahrain"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Bahrain'){echo ' selected';}?>>Asia/Bahrain</option>
                            <option value="Asia/Baku"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Baku'){echo ' selected';}?>>Asia/Baku</option>
                            <option value="Asia/Bangkok"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Bangkok'){echo ' selected';}?>>Asia/Bangkok</option>
                            <option value="Asia/Barnaul"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Barnaul'){echo ' selected';}?>>Asia/Barnaul</option>
                            <option value="Asia/Beirut"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Beirut'){echo ' selected';}?>>Asia/Beirut</option>
                            <option value="Asia/Bishkek"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Bishkek'){echo ' selected';}?>>Asia/Bishkek</option>
                            <option value="Asia/Brunei"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Brunei'){echo ' selected';}?>>Asia/Brunei</option>
                            <option value="Asia/Chita"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Chita'){echo ' selected';}?>>Asia/Chita</option>
                            <option value="Asia/Choibalsan"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Choibalsan'){echo ' selected';}?>>Asia/Choibalsan</option>
                            <option value="Asia/Colombo"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Colombo'){echo ' selected';}?>>Asia/Colombo</option>
                            <option value="Asia/Damascus"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Damascus'){echo ' selected';}?>>Asia/Damascus</option>
                            <option value="Asia/Dhaka"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Dhaka'){echo ' selected';}?>>Asia/Dhaka</option>
                            <option value="Asia/Dili"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Dili'){echo ' selected';}?>>Asia/Dili</option>
                            <option value="Asia/Dubai"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Dubai'){echo ' selected';}?>>Asia/Dubai</option>
                            <option value="Asia/Dushanbe"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Dushanbe'){echo ' selected';}?>>Asia/Dushanbe</option>
                            <option value="Asia/Famagusta"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Famagusta'){echo ' selected';}?>>Asia/Famagusta</option>
                            <option value="Asia/Gaza"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Gaza'){echo ' selected';}?>>Asia/Gaza</option>
                            <option value="Asia/Hebron"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Hebron'){echo ' selected';}?>>Asia/Hebron</option>
                            <option value="Asia/Ho_Chi_Minh"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Ho_Chi_Minh'){echo ' selected';}?>>Asia/Ho_Chi_Minh</option>
                            <option value="Asia/Hong_Kong"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Hong_Kong'){echo ' selected';}?>>Asia/Hong_Kong</option>
                            <option value="Asia/Hovd"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Hovd'){echo ' selected';}?>>Asia/Hovd</option>
                            <option value="Asia/Irkutsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Irkutsk'){echo ' selected';}?>>Asia/Irkutsk</option>
                            <option value="Asia/Jakarta"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Jakarta'){echo ' selected';}?>>Asia/Jakarta</option>
                            <option value="Asia/Jayapura"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Jayapura'){echo ' selected';}?>>Asia/Jayapura</option>
                            <option value="Asia/Jerusalem"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Jerusalem'){echo ' selected';}?>>Asia/Jerusalem</option>
                            <option value="Asia/Kabul"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Kabul'){echo ' selected';}?>>Asia/Kabul</option>
                            <option value="Asia/Kamchatka"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Kamchatka'){echo ' selected';}?>>Asia/Kamchatka</option>
                            <option value="Asia/Karachi"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Karachi'){echo ' selected';}?>>Asia/Karachi</option>
                            <option value="Asia/Kathmandu"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Kathmandu'){echo ' selected';}?>>Asia/Kathmandu</option>
                            <option value="Asia/Khandyga"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Khandyga'){echo ' selected';}?>>Asia/Khandyga</option>
                            <option value="Asia/Kolkata"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Kolkata'){echo ' selected';}?>>Asia/Kolkata</option>
                            <option value="Asia/Krasnoyarsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Krasnoyarsk'){echo ' selected';}?>>Asia/Krasnoyarsk</option>
                            <option value="Asia/Kuala_Lumpur"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Kuala_Lumpur'){echo ' selected';}?>>Asia/Kuala_Lumpur</option>
                            <option value="Asia/Kuching"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Kuching'){echo ' selected';}?>>Asia/Kuching</option>
                            <option value="Asia/Kuwait"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Kuwait'){echo ' selected';}?>>Asia/Kuwait</option>
                            <option value="Asia/Macau"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Macau'){echo ' selected';}?>>Asia/Macau</option>
                            <option value="Asia/Magadan"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Magadan'){echo ' selected';}?>>Asia/Magadan</option>
                            <option value="Asia/Makassar"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Makassar'){echo ' selected';}?>>Asia/Makassar</option>
                            <option value="Asia/Manila"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Manila'){echo ' selected';}?>>Asia/Manila</option>
                            <option value="Asia/Muscat"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Muscat'){echo ' selected';}?>>Asia/Muscat</option>
                            <option value="Asia/Nicosia"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Nicosia'){echo ' selected';}?>>Asia/Nicosia</option>
                            <option value="Asia/Novokuznetsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Novokuznetsk'){echo ' selected';}?>>Asia/Novokuznetsk</option>
                            <option value="Asia/Novosibirsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Novosibirsk'){echo ' selected';}?>>Asia/Novosibirsk</option>
                            <option value="Asia/Omsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Omsk'){echo ' selected';}?>>Asia/Omsk</option>
                            <option value="Asia/Oral"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Oral'){echo ' selected';}?>>Asia/Oral</option>
                            <option value="Asia/Phnom_Penh"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Phnom_Penh'){echo ' selected';}?>>Asia/Phnom_Penh</option>
                            <option value="Asia/Pontianak"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Pontianak'){echo ' selected';}?>>Asia/Pontianak</option>
                            <option value="Asia/Pyongyang"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Pyongyang'){echo ' selected';}?>>Asia/Pyongyang</option>
                            <option value="Asia/Qatar"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Qatar'){echo ' selected';}?>>Asia/Qatar</option>
                            <option value="Asia/Qostanay"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Qostanay'){echo ' selected';}?>>Asia/Qostanay</option>
                            <option value="Asia/Qyzylorda"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Qyzylorda'){echo ' selected';}?>>Asia/Qyzylorda</option>
                            <option value="Asia/Riyadh"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Riyadh'){echo ' selected';}?>>Asia/Riyadh</option>
                            <option value="Asia/Sakhalin"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Sakhalin'){echo ' selected';}?>>Asia/Sakhalin</option>
                            <option value="Asia/Samarkand"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Samarkand'){echo ' selected';}?>>Asia/Samarkand</option>
                            <option value="Asia/Seoul"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Seoul'){echo ' selected';}?>>Asia/Seoul</option>
                            <option value="Asia/Shanghai"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Shanghai'){echo ' selected';}?>>Asia/Shanghai</option>
                            <option value="Asia/Singapore"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Singapore'){echo ' selected';}?>>Asia/Singapore</option>
                            <option value="Asia/Srednekolymsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Srednekolymsk'){echo ' selected';}?>>Asia/Srednekolymsk</option>
                            <option value="Asia/Taipei"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Taipei'){echo ' selected';}?>>Asia/Taipei</option>
                            <option value="Asia/Tashkent"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Tashkent'){echo ' selected';}?>>Asia/Tashkent</option>
                            <option value="Asia/Tbilisi"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Tbilisi'){echo ' selected';}?>>Asia/Tbilisi</option>
                            <option value="Asia/Tehran"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Tehran'){echo ' selected';}?>>Asia/Tehran</option>
                            <option value="Asia/Thimphu"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Thimphu'){echo ' selected';}?>>Asia/Thimphu</option>
                            <option value="Asia/Tokyo"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Tokyo'){echo ' selected';}?>>Asia/Tokyo</option>
                            <option value="Asia/Tomsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Tomsk'){echo ' selected';}?>>Asia/Tomsk</option>
                            <option value="Asia/Ulaanbaatar"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Ulaanbaatar'){echo ' selected';}?>>Asia/Ulaanbaatar</option>
                            <option value="Asia/Urumqi"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Urumqi'){echo ' selected';}?>>Asia/Urumqi</option>
                            <option value="Asia/Ust-Nera"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Ust-Nera'){echo ' selected';}?>>Asia/Ust-Nera</option>
                            <option value="Asia/Vientiane"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Vientiane'){echo ' selected';}?>>Asia/Vientiane</option>
                            <option value="Asia/Vladivostok"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Vladivostok'){echo ' selected';}?>>Asia/Vladivostok</option>
                            <option value="Asia/Yakutsk"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Yakutsk'){echo ' selected';}?>>Asia/Yakutsk</option>
                            <option value="Asia/Yangon"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Yangon'){echo ' selected';}?>>Asia/Yangon</option>
                            <option value="Asia/Yekaterinburg"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Yekaterinburg'){echo ' selected';}?>>Asia/Yekaterinburg</option>
                            <option value="Asia/Yerevan"<?php if(CONFIG_SITE_TIMEZONE=='Asia/Yerevan'){echo ' selected';}?>>Asia/Yerevan</option>

                            <option disabled>---------- Atlantic ----------</option>
                            <option value="Atlantic/Azores"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Azores'){echo ' selected';}?>>Atlantic/Azores</option>
                            <option value="Atlantic/Bermuda"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Bermuda'){echo ' selected';}?>>Atlantic/Bermuda</option>
                            <option value="Atlantic/Canary"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Canary'){echo ' selected';}?>>Atlantic/Canary</option>
                            <option value="Atlantic/Cape_Verde"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Cape_Verde'){echo ' selected';}?>>Atlantic/Cape_Verde</option>
                            <option value="Atlantic/Faroe"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Faroe'){echo ' selected';}?>>Atlantic/Faroe</option>
                            <option value="Atlantic/Madeira"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Madeira'){echo ' selected';}?>>Atlantic/Madeira</option>
                            <option value="Atlantic/Reykjavik"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Reykjavik'){echo ' selected';}?>>Atlantic/Reykjavik</option>
                            <option value="Atlantic/South_Georgia"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/South_Georgia'){echo ' selected';}?>>Atlantic/South_Georgia</option>
                            <option value="Atlantic/St_Helena"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/St_Helena'){echo ' selected';}?>>Atlantic/St_Helena</option>
                            <option value="Atlantic/Stanley"<?php if(CONFIG_SITE_TIMEZONE=='Atlantic/Stanley'){echo ' selected';}?>>Atlantic/Stanley</option>

                            <option disabled>---------- Australia ----------</option>
                            <option value="Australia/Adelaide"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Adelaide'){echo ' selected';}?>>Australia/Adelaide</option>
                            <option value="Australia/Brisbane"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Brisbane'){echo ' selected';}?>>Australia/Brisbane</option>
                            <option value="Australia/Broken_Hill"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Broken_Hill'){echo ' selected';}?>>Australia/Broken_Hill</option>
                            <option value="Australia/Darwin"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Darwin'){echo ' selected';}?>>Australia/Darwin</option>
                            <option value="Australia/Eucla"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Eucla'){echo ' selected';}?>>Australia/Eucla</option>
                            <option value="Australia/Hobart"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Hobart'){echo ' selected';}?>>Australia/Hobart</option>
                            <option value="Australia/Lindeman"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Lindeman'){echo ' selected';}?>>Australia/Lindeman</option>
                            <option value="Australia/Lord_Howe"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Lord_Howe'){echo ' selected';}?>>Australia/Lord_Howe</option>
                            <option value="Australia/Melbourne"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Melbourne'){echo ' selected';}?>>Australia/Melbourne</option>
                            <option value="Australia/Perth"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Perth'){echo ' selected';}?>>Australia/Perth</option>
                            <option value="Australia/Sydney"<?php if(CONFIG_SITE_TIMEZONE=='Australia/Sydney'){echo ' selected';}?>>Australia/Sydney</option>

                            <option disabled>---------- Europe ----------</option>
                            <option value="Europe/Amsterdam"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Amsterdam'){echo ' selected';}?>>Europe/Amsterdam</option>
                            <option value="Europe/Andorra"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Andorra'){echo ' selected';}?>>Europe/Andorra</option>
                            <option value="Europe/Astrakhan"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Astrakhan'){echo ' selected';}?>>Europe/Astrakhan</option>
                            <option value="Europe/Athens"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Athens'){echo ' selected';}?>>Europe/Athens</option>
                            <option value="Europe/Belgrade"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Belgrade'){echo ' selected';}?>>Europe/Belgrade</option>
                            <option value="Europe/Berlin"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Berlin'){echo ' selected';}?>>Europe/Berlin</option>
                            <option value="Europe/Bratislava"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Bratislava'){echo ' selected';}?>>Europe/Bratislava</option>
                            <option value="Europe/Brussels"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Brussels'){echo ' selected';}?>>Europe/Brussels</option>
                            <option value="Europe/Bucharest"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Bucharest'){echo ' selected';}?>>Europe/Bucharest</option>
                            <option value="Europe/Budapest"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Budapest'){echo ' selected';}?>>Europe/Budapest</option>
                            <option value="Europe/Busingen"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Busingen'){echo ' selected';}?>>Europe/Busingen</option>
                            <option value="Europe/Chisinau"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Chisinau'){echo ' selected';}?>>Europe/Chisinau</option>
                            <option value="Europe/Copenhagen"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Copenhagen'){echo ' selected';}?>>Europe/Copenhagen</option>
                            <option value="Europe/Dublin"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Dublin'){echo ' selected';}?>>Europe/Dublin</option>
                            <option value="Europe/Gibraltar"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Gibraltar'){echo ' selected';}?>>Europe/Gibraltar</option>
                            <option value="Europe/Guernsey"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Guernsey'){echo ' selected';}?>>Europe/Guernsey</option>
                            <option value="Europe/Helsinki"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Helsinki'){echo ' selected';}?>>Europe/Helsinki</option>
                            <option value="Europe/Isle_of_Man"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Isle_of_Man'){echo ' selected';}?>>Europe/Isle_of_Man</option>
                            <option value="Europe/Istanbul"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Istanbul'){echo ' selected';}?>>Europe/Istanbul</option>
                            <option value="Europe/Jersey"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Jersey'){echo ' selected';}?>>Europe/Jersey</option>
                            <option value="Europe/Kaliningrad"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Kaliningrad'){echo ' selected';}?>>Europe/Kaliningrad</option>
                            <option value="Europe/Kiev"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Kiev'){echo ' selected';}?>>Europe/Kiev</option>
                            <option value="Europe/Kirov"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Kirov'){echo ' selected';}?>>Europe/Kirov</option>
                            <option value="Europe/Lisbon"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Lisbon'){echo ' selected';}?>>Europe/Lisbon</option>
                            <option value="Europe/Ljubljana"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Ljubljana'){echo ' selected';}?>>Europe/Ljubljana</option>
                            <option value="Europe/London"<?php if(CONFIG_SITE_TIMEZONE=='Europe/London'){echo ' selected';}?>>Europe/London</option>
                            <option value="Europe/Luxembourg"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Luxembourg'){echo ' selected';}?>>Europe/Luxembourg</option>
                            <option value="Europe/Madrid"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Madrid'){echo ' selected';}?>>Europe/Madrid</option>
                            <option value="Europe/Malta"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Malta'){echo ' selected';}?>>Europe/Malta</option>
                            <option value="Europe/Mariehamn"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Mariehamn'){echo ' selected';}?>>Europe/Mariehamn</option>
                            <option value="Europe/Minsk"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Minsk'){echo ' selected';}?>>Europe/Minsk</option>
                            <option value="Europe/Monaco"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Monaco'){echo ' selected';}?>>Europe/Monaco</option>
                            <option value="Europe/Moscow"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Moscow'){echo ' selected';}?>>Europe/Moscow</option>
                            <option value="Europe/Oslo"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Oslo'){echo ' selected';}?>>Europe/Oslo</option>
                            <option value="Europe/Paris"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Paris'){echo ' selected';}?>>Europe/Paris</option>
                            <option value="Europe/Podgorica"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Podgorica'){echo ' selected';}?>>Europe/Podgorica</option>
                            <option value="Europe/Prague"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Prague'){echo ' selected';}?>>Europe/Prague</option>
                            <option value="Europe/Riga"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Riga'){echo ' selected';}?>>Europe/Riga</option>
                            <option value="Europe/Rome"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Rome'){echo ' selected';}?>>Europe/Rome</option>
                            <option value="Europe/Samara"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Samara'){echo ' selected';}?>>Europe/Samara</option>
                            <option value="Europe/San_Marino"<?php if(CONFIG_SITE_TIMEZONE=='Europe/San_Marino'){echo ' selected';}?>>Europe/San_Marino</option>
                            <option value="Europe/Sarajevo"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Sarajevo'){echo ' selected';}?>>Europe/Sarajevo</option>
                            <option value="Europe/Saratov"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Saratov'){echo ' selected';}?>>Europe/Saratov</option>
                            <option value="Europe/Simferopol"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Simferopol'){echo ' selected';}?>>Europe/Simferopol</option>
                            <option value="Europe/Skopje"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Skopje'){echo ' selected';}?>>Europe/Skopje</option>
                            <option value="Europe/Sofia"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Sofia'){echo ' selected';}?>>Europe/Sofia</option>
                            <option value="Europe/Stockholm"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Stockholm'){echo ' selected';}?>>Europe/Stockholm</option>
                            <option value="Europe/Tallinn"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Tallinn'){echo ' selected';}?>>Europe/Tallinn</option>
                            <option value="Europe/Tirane"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Tirane'){echo ' selected';}?>>Europe/Tirane</option>
                            <option value="Europe/Ulyanovsk"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Ulyanovsk'){echo ' selected';}?>>Europe/Ulyanovsk</option>
                            <option value="Europe/Uzhgorod"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Uzhgorod'){echo ' selected';}?>>Europe/Uzhgorod</option>
                            <option value="Europe/Vaduz"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Vaduz'){echo ' selected';}?>>Europe/Vaduz</option>
                            <option value="Europe/Vatican"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Vatican'){echo ' selected';}?>>Europe/Vatican</option>
                            <option value="Europe/Vienna"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Vienna'){echo ' selected';}?>>Europe/Vienna</option>
                            <option value="Europe/Vilnius"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Vilnius'){echo ' selected';}?>>Europe/Vilnius</option>
                            <option value="Europe/Volgograd"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Volgograd'){echo ' selected';}?>>Europe/Volgograd</option>
                            <option value="Europe/Warsaw"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Warsaw'){echo ' selected';}?>>Europe/Warsaw</option>
                            <option value="Europe/Zagreb"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Zagreb'){echo ' selected';}?>>Europe/Zagreb</option>
                            <option value="Europe/Zaporozhye"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Zaporozhye'){echo ' selected';}?>>Europe/Zaporozhye</option>
                            <option value="Europe/Zurich"<?php if(CONFIG_SITE_TIMEZONE=='Europe/Zurich'){echo ' selected';}?>>Europe/Zurich</option>

                            <option disabled>---------- Indian ----------</option>
                            <option value="Indian/Antananarivo"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Antananarivo'){echo ' selected';}?>>Indian/Antananarivo</option>
                            <option value="Indian/Chagos"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Chagos'){echo ' selected';}?>>Indian/Chagos</option>
                            <option value="Indian/Christmas"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Christmas'){echo ' selected';}?>>Indian/Christmas</option>
                            <option value="Indian/Cocos"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Cocos'){echo ' selected';}?>>Indian/Cocos</option>
                            <option value="Indian/Comoro"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Comoro'){echo ' selected';}?>>Indian/Comoro</option>
                            <option value="Indian/Kerguelen"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Kerguelen'){echo ' selected';}?>>Indian/Kerguelen</option>
                            <option value="Indian/Mahe"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Mahe'){echo ' selected';}?>>Indian/Mahe</option>
                            <option value="Indian/Maldives"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Maldives'){echo ' selected';}?>>Indian/Maldives</option>
                            <option value="Indian/Mauritius"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Mauritius'){echo ' selected';}?>>Indian/Mauritius</option>
                            <option value="Indian/Mayotte"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Mayotte'){echo ' selected';}?>>Indian/Mayotte</option>
                            <option value="Indian/Reunion"<?php if(CONFIG_SITE_TIMEZONE=='Indian/Reunion'){echo ' selected';}?>>Indian/Reunion</option>

                            <option disabled>---------- Pacific ----------</option>
                            <option value="Pacific/Apia"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Apia'){echo ' selected';}?>>Pacific/Apia</option>
                            <option value="Pacific/Auckland"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Auckland'){echo ' selected';}?>>Pacific/Auckland</option>
                            <option value="Pacific/Bougainville"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Bougainville'){echo ' selected';}?>>Pacific/Bougainville</option>
                            <option value="Pacific/Chatham"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Chatham'){echo ' selected';}?>>Pacific/Chatham</option>
                            <option value="Pacific/Chuuk"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Chuuk'){echo ' selected';}?>>Pacific/Chuuk</option>
                            <option value="Pacific/Easter"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Easter'){echo ' selected';}?>>Pacific/Easter</option>
                            <option value="Pacific/Efate"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Efate'){echo ' selected';}?>>Pacific/Efate</option>
                            <option value="Pacific/Enderbury"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Enderbury'){echo ' selected';}?>>Pacific/Enderbury</option>
                            <option value="Pacific/Fakaofo"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Fakaofo'){echo ' selected';}?>>Pacific/Fakaofo</option>
                            <option value="Pacific/Fiji"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Fiji'){echo ' selected';}?>>Pacific/Fiji</option>
                            <option value="Pacific/Funafuti"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Funafuti'){echo ' selected';}?>>Pacific/Funafuti</option>
                            <option value="Pacific/Galapagos"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Galapagos'){echo ' selected';}?>>Pacific/Galapagos</option>
                            <option value="Pacific/Gambier"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Gambier'){echo ' selected';}?>>Pacific/Gambier</option>
                            <option value="Pacific/Guadalcanal"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Guadalcanal'){echo ' selected';}?>>Pacific/Guadalcanal</option>
                            <option value="Pacific/Guam"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Guam'){echo ' selected';}?>>Pacific/Guam</option>
                            <option value="Pacific/Honolulu"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Honolulu'){echo ' selected';}?>>Pacific/Honolulu</option>
                            <option value="Pacific/Kiritimati"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Kiritimati'){echo ' selected';}?>>Pacific/Kiritimati</option>
                            <option value="Pacific/Kosrae"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Kosrae'){echo ' selected';}?>>Pacific/Kosrae</option>
                            <option value="Pacific/Kwajalein"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Kwajalein'){echo ' selected';}?>>Pacific/Kwajalein</option>
                            <option value="Pacific/Majuro"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Majuro'){echo ' selected';}?>>Pacific/Majuro</option>
                            <option value="Pacific/Marquesas"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Marquesas'){echo ' selected';}?>>Pacific/Marquesas</option>
                            <option value="Pacific/Midway"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Midway'){echo ' selected';}?>>Pacific/Midway</option>
                            <option value="Pacific/Nauru"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Nauru'){echo ' selected';}?>>Pacific/Nauru</option>
                            <option value="Pacific/Niue"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Niue'){echo ' selected';}?>>Pacific/Niue</option>
                            <option value="Pacific/Norfolk"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Norfolk'){echo ' selected';}?>>Pacific/Norfolk</option>
                            <option value="Pacific/Noumea"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Noumea'){echo ' selected';}?>>Pacific/Noumea</option>
                            <option value="Pacific/Pago_Pago"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Pago_Pago'){echo ' selected';}?>>Pacific/Pago_Pago</option>
                            <option value="Pacific/Palau"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Palau'){echo ' selected';}?>>Pacific/Palau</option>
                            <option value="Pacific/Pitcairn"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Pitcairn'){echo ' selected';}?>>Pacific/Pitcairn</option>
                            <option value="Pacific/Pohnpei"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Pohnpei'){echo ' selected';}?>>Pacific/Pohnpei</option>
                            <option value="Pacific/Port_Moresby"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Port_Moresby'){echo ' selected';}?>>Pacific/Port_Moresby</option>
                            <option value="Pacific/Rarotonga"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Rarotonga'){echo ' selected';}?>>Pacific/Rarotonga</option>
                            <option value="Pacific/Saipan"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Saipan'){echo ' selected';}?>>Pacific/Saipan</option>
                            <option value="Pacific/Tahiti"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Tahiti'){echo ' selected';}?>>Pacific/Tahiti</option>
                            <option value="Pacific/Tarawa"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Tarawa'){echo ' selected';}?>>Pacific/Tarawa</option>
                            <option value="Pacific/Tongatapu"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Tongatapu'){echo ' selected';}?>>Pacific/Tongatapu</option>
                            <option value="Pacific/Wake"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Wake'){echo ' selected';}?>>Pacific/Wake</option>
                            <option value="Pacific/Wallis"<?php if(CONFIG_SITE_TIMEZONE=='Pacific/Wallis'){echo ' selected';}?>>Pacific/Wallis</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Database</h2>
                    <div class="grid grid-cols-2">
                        <label for="database_host">Database Host</label>
                        <input id="database_host" name="database_host" type="text" value="<?php echo DATABASE_HOST; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_username">Database Username</label>
                        <input id="database_username" name="database_username" type="text" value="<?php echo DATABASE_USERNAME; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_password">Database Password</label>
                        <input id="database_password" name="database_password" type="password" value="<?php echo DATABASE_PASSWORD; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_port">Database Port</label>
                        <input id="database_port" name="database_port" type="text" value="<?php echo DATABASE_PORT; ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_prefix">Database Prefix</label>
                        <input id="database_prefix" name="database_prefix" type="text" value="<?php echo DATABASE_PREFIX; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Email</h2>
                    <div class="grid grid-cols-2">
                        <label for="email_admin">Administrator's Email</label>
                        <input id="email_admin" name="email_admin" type="text" value="<?php echo CONFIG_EMAIL_ADMIN; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_function">Email Function</label>
                        <select id="email_function" name="email_function" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="phpmail" selected>phpmail (Recommended)</option>
                            <option disabled>SMTP (Coming Soon)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_sendfrom">Email Sendfrom</label>
                        <input id="email_sendfrom" name="email_sendfrom" type="text" value="<?php echo CONFIG_EMAIL_SENDFROM; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Pages and Articles</h2>
                    <div class="grid grid-cols-2">
                        <label for="page_approvals">Page Approvals</label>
                        <select id="page_approvals" name="page_approvals" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_PAGE_APPROVALS){echo' selected';} ?>>True</option>
                            <option value="false"<?php if(!CONFIG_PAGE_APPROVALS){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="article_approvals">Article Approvals</label>
                        <select id="article_approvals" name="article_approvals" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>True</option>
                            <option value="false"<?php if(!CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_title_chars">Maximum Title Length</label>
                        <input id="max_title_chars" name="max_title_chars" type="number" value="<?php echo CONFIG_MAX_TITLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_page_chars">Maximum Page Content Length</label>
                        <input id="max_page_chars" name="max_page_chars" type="number" value="<?php echo CONFIG_MAX_PAGE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_article_chars">Maximum Article Content Length</label>
                        <input id="max_article_chars" name="max_article_chars" type="number" value="<?php echo CONFIG_MAX_ARTICLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_references_chars">Maximum References Length</label>
                        <input id="max_references_chars" name="max_references_chars" type="number" value="<?php echo CONFIG_MAX_REFERENCES_CHARS; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Security System</h2>
                    <div class="grid grid-cols-2">
                        <label for="security_active">Security Active</label>
                        <select id="security_active" name="security_active" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(SECURITY_ACTIVE){echo' selected';} ?>>True (Recommended)</option>
                            <option value="false"<?php if(!SECURITY_ACTIVE){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="article_approvals">Logging Active</label>
                        <select id="article_approvals" name="article_approvals" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>True (Recommended)</option>
                            <option value="false"<?php if(!CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_mode">Security Mode</label>
                        <select id="security_mode" name="security_mode" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="clean"<?php if(SECURITY_MODE == 'clean'){echo' selected';} ?>>Clean (Recommended)</option>
                            <option value="halt"<?php if(SECURITY_MODE == 'halt'){echo' selected';} ?>>Halt</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Developer Tools</h2>
                    <div class="grid grid-cols-2">
                        <label for="debug">Debug Mode</label>
                        <select id="debug" name="debug" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_DEBUG){echo' selected';} ?>>True</option>
                            <option value="false"<?php if(!CONFIG_DEBUG){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2">
                    <div></div>
                    <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-save" aria-hidden="true"></i>
                        </span>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>