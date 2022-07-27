<?php

echo 'Please wait...';

use Boa\App;
use Boa\Security\Encryption;

global $API_LOCATION;

require_once __DIR__.'/../../../Processes/Boa/Boa.php';

new App();
$Encryption = new Encryption();

$Username = $Encryption->hash($_POST['username']);
$Password = $Encryption->hash($_POST['password'].SECURITY_HASH_SALT);
?>
<script>
    let data = {element: "barium"};

    fetch("<?= $API_LOCATION ?>/<?= API_VERSION ?>/authenticate", {
        method: "GET",
        headers: {'Content-Type': 'application/json'}
    }).then(res => {
        console.log("Request complete! response:", res);
    });
</script>