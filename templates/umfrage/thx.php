<?php
include __DIR__ . "/../partials/header.php";
?>

<div class="app-inner">
    <h1>Danke, <?= $politician->name["fname"] ?> <?= $politician->name["lname"] ?>!</h1>
    <p class="lead">Wir haben Ihre Antworten entgegengenommen und werden diese nun verarbeiten. Die Resultate werden voraussichtlich Anfang Dezember auf <a href="www.wohnrating.ch">www.wohnrating.ch</a> veröffentlicht. Sollten Sie Fragen oder Bemerkung haben, können Sie sich jederzeit unter <a href="mailto:info@wohnrating.ch">info@wohnrating.ch</a> an uns wenden.</p>
</div>


<?php
include __DIR__ . "/../partials/footer.php";
?>