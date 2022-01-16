<?php /** @var Array $data */ ?>
<div class="main">
    <script src="public/file.js"></script>
    <?php $numOffers = 0;
    $numPages = 1;
    $totalOffers = 0;
    $totalPages = 0;?>
    <h4 style="text-align: left; font-size: larger">Ponuky doučovania:</h4>
    <?php foreach ($data['offers'] as $post) {
    if ($post->getTutor() == 1) {
        $totalOffers++;
    }}
    $totalPages = ($totalOffers - ($totalOffers % 12))/12 + 1;
    ?>
    <div class="container mt-5">
        <div class="row" style="justify-content: left">
            <?php foreach ($data['offers'] as $post) {
                if ($post->getTutor() == 1) { ?>
                    <?php $numOffers++;
                    $nazov = 'column' . $numOffers; ?>
                    <div class="col-md-3" style="padding: 10px"
                         id="<?= $nazov ?>"
                         onmouseover="increase(this.id)"
                         onmouseout="reset(this.id)">
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
    <div class="btn-group">
        <button class="btn btn-default btn-primary" type="submit">Začiatok</button>
        <button class="btn btn-default btn-primary" type="submit"><?=$numPages ?></button>
        <button class="btn btn-default btn-primary" type="submit"><?=$numPages +1 ?></button>
        <button class="btn btn-default btn-primary" type="submit"><?=$numPages +2 ?></button>
        <button class="btn btn-default btn-primary" type="submit">Koniec</button>

    </div>

</div>

