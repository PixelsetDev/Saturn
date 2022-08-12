<?php

$DashErrors = '';
if (DEBUG) { $DashErrors .= 'Debugging Enabled. '; };
if (DEBUG_INSECURE) { $DashErrors .= 'Insecure Debugging Enabled. '; };
if (EMAIL_SENDFROM == 'noreply@example.com') { $DashErrors .= 'Sendfrom email is still default and likely will not work. '; }
if (WEBSITE_NAME == 'Saturn') { $DashErrors .= 'Website name has not been set. '; }