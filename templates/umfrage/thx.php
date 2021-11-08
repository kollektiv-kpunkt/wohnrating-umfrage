<?php
include __DIR__ . "/../partials/header.php";
?>

<div class="app-inner">
    <h1>Danke, <?= $politician->name["fname"] ?> <?= $politician->name["lname"] ?>!</h1>
    <p class="lead">Wir haben Ihre Antworten entgegengenommen und werden diese nun verarbeiten. Das Wohnrating wird im Rahmen der Wahlkampfphase Ihrer Gemeinde veröffentlicht: Wir werden uns bei Ihnen melden, wenn ihr Profil auf unserer Webseite veröffentlich wird. Bios dahin stehen wir Ihnen gerne unter der E-Mail Adresse <a href="mailto: infowohnrating.ch">info@wohnrating.ch</a> zur Verfügung.</p>
    <a href="/registrieren/<?= uniqid("politician_") ?>" class="button mt4">Weitere Registration</a>
</div>


<?php
include __DIR__ . "/../partials/footer.php";
?>