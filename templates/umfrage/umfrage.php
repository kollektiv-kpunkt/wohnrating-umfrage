<?php
include __DIR__ . "/../partials/header.php";

$questions = [
    '1. Haben Sie der eidgenössischen Initiative «Mehr bezahlbare Wohnungen» (Abstimmung vom 9. Februar 2020), die das Ziel verfolgte, das Angebot an preisgünstigem Wohnraum zu erhöhen, zu gestimmt?',
    '2. Zurzeit sind <a href="https://www.parlament.ch/press-releases/Pages/mm-rk-n-2021-09-06.aspx?lang=1031" target="_blank">vier parlamentarische Initiativen</a> im nationalen Parlament hängig: Sie zielen darauf ab, das Mietrecht zu schwächen, indem die Untermiete limitiert, Mietzinserhöhungen vereinfacht oder der Kündigungsschutz geschwächt werden soll. Unterstützen Sie diese Bestrebungen?',
    '3. Der gemeinnützige Wohnungsbau orientiert sich an der Kostenmiete und wirtschaftet ohne Gewinnabsichten. Erachten Sie in Ihrer Gemeinde einen höheren Anteil an gemeinnützigen Wohnungen für wünschenswert?',
    '4. Erachten Sie es als Aufgabe ihrer Gemeinde, darauf zu achten, dass Wohnraum für ältere Menschen, Haushalte mit kleinem Budget, vielen Kindern oder Personen in Ausbildung vorhanden ist?',
    '5. Soll ihre Gemeinde bei Landverkäufen oder der Einrichtung eines Baurechts prinzipiell gemeinnützige Wohnbauträger berücksichtigen?',
    '6. Würden Sie sich dafür einsetzen, dass in ihrer Gemeinde Zonen für preisgünstiges Wohnen (nach Artikel 49b des Planungs- und Baugesetzes) errichtet werden? Dadurch können ein Mindestanteil an preisgünstigem Wohnraum und höchstzulässige Mietzinse festgesetzt werden.',
    '7. Wohnbaugenossenschaften bringen einen breiten sozialen und gesellschaftlichen Nutzen, indem sie z.B. auf eine gute Belegung der Wohnungen achten, in ökologische Massnahmen investieren und besonders in den Städten zu einer sozialen Durchmischung beitragen und für lebendige Quartiere sorgen. Können Sie dieser Aussage zustimmen?',
    '8. Ist es Aufgabe der öffentlichen Hand Anreize zu schaffen, dass Immobilienbesitzer*innen Sanierungen im bewohnten Zustand vornehmen, so dass die Mieter*innen in den Wohnungen bleiben können, oder ein Rückkehrrecht erhalten, nachdem die Wohnungen saniert oder umgebaut wurden?',
    '9. Braucht es künftig ein «Wohnschutzgesetz», das Mieter*innen vor Leerkündigungen und preistreibenden Renovationen schützt?'
];
?>

<div class="app-inner">
    <h1>Umfrage</h1>
    <p class="lead">Beantworten Sie bitte folgende Fragen. Eine unbeantwortete Frage kann Ihr Resultat verfälschen.</p>
    <form action="#" id="questionaire" novalidate>
        <input type="hidden" name="uuid" value="<?= $politician->uuid ?>">
        <?php
        $i = 0;
        foreach ($questions as $question):
        ?>
        <div class="question">
            <h2 class="question-title"><?= $question ?></h2>
            <div class="answers mt6">
                <div class="radio-group">
                    <input type="radio" name="answers[<?=$i?>]" id="answer<?= $i ?>-1" value="1" class="answer">
                    <label for="answer<?= $i ?>-1">Ja</label>
                </div>
                <div class="radio-group">
                    <input type="radio" name="answers[<?=$i?>]" id="answer<?= $i ?>-2" value="2" class="answer">
                    <label for="answer<?= $i ?>-2">Eher Ja</label>
                </div>
                <div class="radio-group">
                    <input type="radio" name="answers[<?=$i?>]" id="answer<?= $i ?>-3" value="3" class="answer">
                    <label for="answer<?= $i ?>-3">Eher Nein</label>
                </div>
                <div class="radio-group">
                    <input type="radio" name="answers[<?=$i?>]" id="answer<?= $i ?>-4" value="4" class="answer">
                    <label for="answer<?= $i ?>-4">Nein</label>
                </div>
            </div>
            <div class="radio-group mt5">
                <input type="radio" name="answers[<?=$i?>]" id="answer<?= $i ?>-5" value="5" class="answer" checked>
                <label for="answer<?= $i ?>-5">Frage überspringen</label>
            </div>
        </div>
        <?php
        $i++;
        endforeach;
        ?>
        <button class="button mt7" type="submit" style="min-width: 50%; margin-left: auto">Weiter</button>
    </form>
</div>

<script>
$(document).on("submit", "#questionaire", function(e){
    e.preventDefault()

    var formData = $(this).serialize()

    $.ajax({
        url : "/questionaire",
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