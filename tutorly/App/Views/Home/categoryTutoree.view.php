<?php /** @var Array $data */ ?>
<div class="main">
    <h4 style="text-align: left; font-size: larger">Hľadajúci doučovanie:</h4>

    <div class="container mt-5">
        <div class="row" style="justify-content: left">
            <?php foreach ($data['offers'] as $post) {
                if ($post->getTutor() == 0) { ?>
                    <div class="col-md-3" style="padding: 10px">
                        <form method="post" action="?c=offer&a=singleOffer">
                            <input type="hidden" name="parid" value="<?= $post->getId() ?>">
                            <button class="btn btn-primary  text-uppercase fw-bold"
                                    onmouseover="style.backgroundColor='white'"
                                    onmouseout="style.backgroundColor='#f1f1f1'"
                                    style="display: flex;justify-content: center;align-items: center;text-align: center; align-content:center;background-color: #f1f1f1; color:#64496d; border-color: white"
                                    class="floated"
                                    type="submit">
                                <?= $post->getTitle() ?>
                            </button>
                        </form>

                        <?php foreach ($data['logins'] as $user) {
                            if ($user->getEmail() == $post->getLoginfk()) {
                                if ($user->getProfilepic() != "") { ?>
                                    <?php if ($user->getProfilepic() != "") { ?>
                                        <img class="pp"
                                             src="<?= \App\Config\Configuration::UPLOAD_DIR . $user->getProfilepic() ?>"
                                             class="rounded" alt="Chyba!">
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="empty_pp"></div>
                                <?php }
                            }
                        } ?>

                        <p><?= $post->getInfo() ?></p>
                        <p><strong>Kontakt: </strong><?= $post->getContact() ?></p>

                        <form method="post" action="?c=offer&a=singleOffer">
                            <input type="hidden" name="parid" value="<?= $post->getId() ?>">
                            <button class="btn btn-primary" style="background: none; color:#64496d; border-color: white"
                                    type="submit">
                                Kliknite pre viac informácií..
                            </button>
                        </form>

                    </div>
                <?php }
            } ?>


        </div>
    </div>
    <p></p>


</div>

