<?php
include __DIR__ . "/../partials/header.php";
?>

<div class="app-inner">
    <h1>Registration</h1>
    <p class="lead">Bitte füllen Sie folgendes Formular aus, um sich für das Wohnrating zu registrieren:</p>
    <form action="#" id="personal-details" class="grid-form">
        <input type="hidden" name="uuid" value="<?= $politicianId ?>">
        <div class="form-group">
            <label for="fname">Vorname</label>
            <input type="text" id="fname" name="fname" required>
        </div>
        <div class="form-group">
            <label for="lname">Nachname</label>
            <input type="text" id="lname" name="lname" required>
        </div>
        <div class="form-group">
            <label for="email">E-Mail Adresse</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="year">Jahrgang</label>
            <input type="number" id="year" name="year" required>
        </div>
        <div class="form-group">
            <label for="beruf">Berufsbezeichnung</label>
            <input type="text" id="beruf" name="beruf" required>
        </div>
        <div class="form-group">
            <label for="behörde">Behörde</label>
            <select class="select2" name="behörde" required>
                <option value="" disabled selected>Bitte auswählen</option>
                <option value="gr">Gemeinderat (Legislative)</option>
                <option value="sr">Stadtrat (Exekutive)</option>
            </select>
        </div>
        <div class="form-group fullwidth">
            <label for="partycode">Partei Code</label>
            <input type="password" id="partycode" name="partycode" required>
            <small class="helper mt3" style="display: block">Der Partei-Code dient zur Verifizierung ihrer Registration. Sie erhalten den Code von den zuständigen Personen in Ihrem Parteisekretariat. Sollte Ihnen kein solcher Code zur Verfügung stellen, obwohl sie in einer der Zürcher Parlamentsgemeinden zur Wahl stellen, kontaktieren Sie uns bitte <a href="mailto:info@wohnrating.ch">hier.</a></small>
        </div>
        <div class="form-group fullwidth">
            <label for="gemeinde">Gemeinde</label>
            <select class="select2" name="gemeinde" required>
                <option value="" disabled selected>Bitte auswählen</option>
                <?php
                $gemeinden = json_decode(file_get_contents(__DIR__ . "/../../data/gemeinden/gemeinden.json"), true);
                $gemeinden = array_values(array_filter($gemeinden, function($gemeinde) {
                    return $gemeinde["gde_parlament"] == 1;
                }));
                foreach ($gemeinden as $key => $gemeinde): ?>
                    <option value="<?= $gemeinde["gde_nr"] ?>"><?= $gemeinde["gde_name"] ?></option>
                <?php
                endforeach;
                ?>
            </select>
            <small class="helper mt3" style="display: block">Als Gemeinderatskandidat:in in Zürich bitte den Wahlkreis auswählen.</small>
        </div>
        <button type="submit" class="button mt6">Weiter</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});

$(document).on("submit", "#personal-details", function(e){
    e.preventDefault()

    var formData = $(this).serialize()

    $.ajax({
        url : "/register",
        type: "POST",
        data : formData,
        async : false,
        success: function(response, textStatus, jqXHR) {
            if (response.type == "error") {
                var notyf = new Notyf({
                    duration: 6000
                });
                notyf.error(response.msg)
            } else if (response.code == 200) {
                window.location.href = response.next
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
})

</script>

<?php
include __DIR__ . "/../partials/footer.php";
?>