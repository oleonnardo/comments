<?php
    $comentarios = (new \Leonardo\Comments\Facades\Database())->getComments($_SESSION['pageUrl']);
?>

<div class="comments-wrapper">

    <div class="comments-panel">
        <ul>
            <li>
                <?php switch(count($comentarios)) {
                    case 0: echo ""; break;
                    case 1: echo "<span>1</span> comentário"; break;
                    default: echo "<span>".count($comentarios)."</span> comentários";
                } ?>
            </li>
            <li>
                Ordenar por
                <select name="orderby">
                    <option selected value="desc">Mais recente</option>
                    <option value="asc">Mais antigo</option>
                </select>
            </li>
        </ul>
    </div>

    <?php if(is_array($comentarios) && count($comentarios)) { ?>

        <?php foreach ($comentarios as $key => $item) { ?>
            <div class="comments-items">
                <div class="c-item__avatar">
                    <img src="assets/img/avatar.png" width="40">
                </div>
                <div class="c-item__comments">
                    <div class="title">
                        <?= $item['nome'] ?>
                        <small class="time">
                            <img src="assets/img/clock.png" width="10">
                            <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                        </small>
                    </div>
                    <div class="comments">
                        <?= strip_tags($item['conteudo'], '<p><ul><li><ol><a><i><b><strong>') ?>
                    </div>
                </div>
            </div>
        <?php } ?>


    <?php } else { ?>

        <p class="text-info">Seja o primeiro a comentar...</p>

    <?php } ?>
</div>
