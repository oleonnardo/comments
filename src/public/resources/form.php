
<form id="comments-form" action="server/save.php" autocomplete="off" method="post">
    <input type="hidden" name="requestURL" value="<?= $_SESSION['pageUrl'] ?>">

    <div class="comments-container">
        <div class="comments-form">
            <img src="assets/img/avatar.png" class="gd-avatar">

            <div class="form-container_texts">
                <input type="text" name="nome" id="nome" required placeholder="Nome Completo">
                <input type="email" name="email" id="email" required placeholder="E-mail">
            </div>

            <div class="textarea-wrapper">
                <textarea name="comentario" id="comentario" placeholder="Deixe um comentário"></textarea>
                <button type="submit" class="btn btn__comments btn__onclick">Enviar</button>
            </div>
        </div>
    </div>
</form>
