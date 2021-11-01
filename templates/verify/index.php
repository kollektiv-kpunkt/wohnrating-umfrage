<?php
require_once __DIR__ . "/../partials/header.php";

?>

<div class="card-container" data-question-number="0" data-polit-id="<?= $politId ?>" id="question-container">
    <div class="card-inner">
        <h4 class="mt0" style="line-height: 1.3" id="question">Bitte bestätigen Sie Ihre Angaben</h4>
        <form action="#" id="confirm-contact">
            <div class="form-group">
                <label for="fname">Vorname</label>
                <input type="text" name="fname" id="fname" value="<?= $contact["name"]["fname"] ?>" required>
            </div>
            <div class="form-group">
                <label for="lname">Nachname</label>
                <input type="text" name="lname" id="lname" value="<?= $contact["name"]["lname"] ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail Adresse</label>
                <input type="email" name="email" id="email" value="<?= $contact["email"] ?>" required>
            </div>
            <div class="form-group">
                <label for="gemeinde">Gemeinde</label>
                <input type="text" name="gemeinde" id="gemeinde" value="<?= findGemeinde($contact["gemeinde"])["name"] ?>" required>
            </div>
            <div class="form-group">
                <label for="Partei">Partei</label>
                <input type="text" name="partei" id="partei" value="<?= findParty($contact["partei"])["name"] ?>" required>
            </div>
            <button type="submit" class="button mt5" style="width: 100%; box-sizing: border-box">Bestätigen</a>
        </form>
    </div>
</div>

<script>
    $(document).on("submit", "#confirm-contact", function(e){
        e.preventDefault();
        var formContent = {"politId" : "<?= $politId ?>", "contact" : JSON.stringify( $(this).serialize() )};
        $.ajax({
            type: "POST",
            url: '/verify',
            data: formContent,
            success: function(response, textStatus, jqXHR) {
                console.log(response)
                if (response.code == 200) {
                    window.location.href="/umfrage/<?= $politId ?>"
                } else {
                    alert(response.text)
                }
            },
        });
    })
</script>

<?php
require_once __DIR__ . "/../partials/footer.php";
?>