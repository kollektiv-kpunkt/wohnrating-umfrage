<?php
include __DIR__ . "/../partials/header.php";
?>

<div class="app-inner">
    <h1>Machen Sie mit beim Wohnrating!</h1>
    <p class="lead" style="font-weight: 500">Der Regionalverband der Wohnbaugenossenschaften (WBG) Zürich und Winterthur und der Mieterinnen und Mieterverband Zürich (MV) haben gemeinsam eine Wahlumfrage mit konkreten Fragen zur Wohn- und Bodenpolitik erstellt. Ziel ist es herauszufinden, welche Kandidierenden sich bei den Gemeindewahlen 2022 für eine nachhaltige Bodenpolitik, bezahlbaren Wohnraum und ein faires Mietrecht einsetzen.</p>
    <p>Anhand der 9 Fragen wird eine Übereinstimmung (in Prozent) mit den Positionen der WBG und des MV erstellt. Die Resultate werden auf unserer Website <a href="https://wohnrating.ch" target="_blank">www.wohnrating.ch</a> (noch nicht online) dargestellt und veröffentlicht. An der Umfrage teilnehmen können alle Kandidierenden für ein Exekutiv- oder Legislativamt in einer Parlamentsgemeinde im Kanton Zürich.</p>
    <a href="/registrieren/<?= uniqid("politician_") ?>" class="button mt4">Registrieren</a>
</div>


<?php
include __DIR__ . "/../partials/footer.php";
?>