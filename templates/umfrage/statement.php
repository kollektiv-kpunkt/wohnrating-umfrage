<?php
include __DIR__ . "/../partials/header.php";
?>

<div class="app-inner">
    <h1>Statement</h1>
    <p class="lead">Wenn Sie möchten, können Sie hier noch ein kurzes Statement verfassen, welches in ihrem Profil angezeigt wird.</p>
    <form action="#" id="statement" style="text-align: end">
        <input type="hidden" name="uuid" value="<?= $politician->uuid ?>">
        <div class="form-group fullwidth" style="text-align: start; position: relative">
            <label for="statement">Ihr Statement</label>
            <textarea name="statement" id="statement" maxlength="225"></textarea>
            <div id="counter">
                <span id="letters">0</span> / 200
            </div>
        </div>
        <button class="button mt6" type="submit" style="min-width: 50%; margin-left: auto">Weiter</button>
    </form>
</div>

<script>
$(document).on("submit", "#statement", function(e){
    e.preventDefault()

    var formData = $(this).serialize()

    $.ajax({
        url : "/statement",
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

$("textarea").each(function () {
  this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
}).on("input", function () {
  this.style.height = "auto";
  this.style.height = (this.scrollHeight) + "px";
  $("#letters").text($(this).val().length)
  if ($(this).val().length >= 200) {
    $("#letters").css("color", "var(--accent)")
    } else if ($(this).val().length > 175) {
        $("#letters").css("color", "orange")
    } else {
        $("#letters").css("color", "unset")
    }

});

</script>


<?php
include __DIR__ . "/../partials/footer.php";
?>