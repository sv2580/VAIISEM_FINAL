<?php /** @var Array $data */ ?>
<div class="main">
    <script src="public/file.js"></script>
    <?php $pocet=0 ?>

    <p><strong>Vitajte na našom webe!</strong> Tutorly je miestom pre každého študenta,
        ktorý sa túži zlepšiť v konkrétnom predmete, pomôcť druhým a poprípade si zarobiť. Doučovanie je možné online.
        Na hlavnej stránke
        nájdete najnovšie ponuky, na ktoré môžete reagovať a vyššie môžete vytvoriť vlastnú ponuku.
    </p>
    <h4 style="text-align: center; font-size: larger">Najnovšie ponuky:</h4>
    <?php
    $totalOffers = 0;
    foreach ($data['offers'] as $post) {
        $totalOffers++;
    };
    ?>
    <div class="container mt-2" style="margin: 0px  ;padding: 0px">
        <div class="row" style="justify-content: center;padding: 10px">
            <?php for ($i = $totalOffers - 1; $i > $totalOffers - 6; $i--) {
                $post = $data['offers'][$i];
                {?>
                    <?php $pocet++;
                    $nazov = 'column'.$pocet;?>
                <div class="col-md-3" style="padding: 10px"
                     id="<?=$nazov?>"
                     onmouseover="increase(this.id)"
                     onmouseout = "reset(this.id)">
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
            <?php }} ?>
            <div class="col-md-3">
                <h3>Vaša ponuka</h3>
                <?php if (\App\Auth::isLogged()) { ?>
                    <p>Tu môže byť vaša ponuka. Stačí kliknúť vyššie na "Pridať nový inzerát" a vyplniť krátky formulár
                        vašich požiadaviek.</p>
                <?php } else { ?>
                    <p>Tu môže byť vaša ponuka. Stačí sa vyššie zaregistrovať, prihlásiť a vyplniť krátky formulár
                        vašich požiadaviek.</p>
                <?php } ?>
                <hr class="solid">
                Pre prezretie viac inzerátov, kliknite hore kategorórie "Doučujem" alebo "Vyhľadávam".
            </div>

        </div>
    </div>
    <p></p>
    <!-- <div class = "separate"></div> -->


</div>

