<?php
include __DIR__ . "/../partials/header.php";
?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<div class="app-inner">
    <h1>Foto</h1>
    <p class="lead">Laden Sie bitte hier ein Foto hoch, welches in ihrem Profil angezeigt werden soll.</p>
    <form class="dropzone mt6" id="kandi-picture">
        <div id="dz-inner" style="width: 100%; max-width: 520px; margin: auto;">
            <h2>Foto hochladen</h2>
            <p>Ziehen Sie ein Bild hier hinein oder wählen Sie ein Bild von Ihrem Gerät aus.</p>
            <small style="display: block; color: #8f8f8f">Bitte beachten Sie, dass das Bild danach in ein Quadrat zugeschnitten werden muss.</small>
        </div>
    </form>
</div>


<script>
Dropzone.autoDiscover = false;
$("form#kandi-picture").dropzone({
    url: "/picture-upload/<?= $politicianId ?>",
    method: 'POST',
    success: function (response) {
        var response = JSON.parse(response.xhr.response);
        setTimeout(() => {
            window.location.href = response.next
        }, 1000);
    }
});
</script>


<style>
    form#kandi-picture {
        position: relative;
        background-color: transparent;
        padding: 0;
        border-radius: 1.5rem;
        border: 2px dashed var(--black);
        padding: 90px
    }

    @media screen and (max-width: 780px) {
        form#kandi-picture { padding: 20px }
    }

    .dz-button {display: none;}
    .dropzone .dz-message {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 100;
        margin: 0
    }

    .dz-started #dz-inner {display: none;}
</style>

<?php
include __DIR__ . "/../partials/footer.php";
?>