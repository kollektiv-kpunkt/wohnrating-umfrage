<?php
require_once __DIR__ . "/../partials/header.php";
?>

<div class="card-container question" data-question-number="0" data-polit-id="<?= $politId ?>" id="question-container">
    <div class="card-inner">
        <p class="step mt0">Frage <span id="question-number">0</span> / <span id="question-total">10</span></p>
        <h4 class="mt1" style="line-height: 1.3" id="question"></h4>
        <div class="btngroup mt5 responsegroup">
            <div class="button choice" data-response-value="4" onclick="form.pickAnswer(this)">Ja</div>
            <div class="button choice" data-response-value="3" onclick="form.pickAnswer(this)">Eher Ja</div>
            <div class="button choice" data-response-value="2" onclick="form.pickAnswer(this)">Eher Nein</div>
            <div class="button choice" data-response-value="1" onclick="form.pickAnswer(this)">Nein</div>
        </div>
        <a data-response="" class="button mt4" id="nextquestion" onclick="form.answerQuestion()">Überspringen</a>
    </div>
</div>

<script src="/js/elements/form.js"></script>

<?php
require_once __DIR__ . "/../partials/footer.php";
?>