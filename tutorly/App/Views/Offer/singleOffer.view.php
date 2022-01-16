<?php /** @var Array $data */ ?>
<script src="public/js/reviewForm.js"></script>
<?php $numFromUser = 0;?>

<?php $numReviews = 0 ?>
<?php foreach ($data['offers'] as $post) {
if ($post->getId() == $data['parid']) { ?>
<?php if ($data['note'] != "") { ?>

    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo($data['note']) ?>
    </div>
<?php } ?>

<?php if ($data['error'] != "") { ?>
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Chyba!</strong> <?php echo $data['error'] ?>
    </div>
<?php } ?>
<div class="container-fluid" style="background-color: #cbc0d5">
    <h2 style="text-align: center;color: black;text-shadow: -1px -1px 0 white, 1px -1px 0 white, -1px 1px 0 white, 1px 1px 0 white;"><?= $post->getTitle() ?></h2>
</div>

<?php foreach ($data['logins'] as $user) {
    if ($user->getEmail() == $post->getLoginfk()) {
        if ($user->getProfilepic() != "") { ?>
            <?php if ($user->getProfilepic() != "") { ?>
                <img class="pp"
                     style="width: 100px !important; height: 100px !important; margin: 10px;float: left;object-fit: cover"
                     src="<?= \App\Config\Configuration::UPLOAD_DIR . $user->getProfilepic() ?>"
                     class="rounded">
            <?php } else { ?>
            <?php } ?>
        <?php } else { ?>
            <div class="empty_pp"
                 style=" border-color: #f1f1f1; border-style: solid; border-width: 1px;  "></div>
        <?php }
    }
} ?>

<h4> Kontakt: </h4>
<p>  <?= $post->getContact() ?> </p>
<h4>Informácie:</h4>
<p><?= $post->getInfo() ?></p>
<h4> Dosiahnuté vzdelanie: </h4>
<p><?= $post->getEducation() ?></p>
<h4> Kurzy, certifikáty: </h4>
<p> <?= $post->getCourses() ?> </p>
<h4> Požadované platobné ohodnotenie: </h4>
<p>  <?= $post->getPay() ?> </p>
<h4> Miesto: </h4>
<p>  <?= $post->getPlace() ?> </p>
<h4> Ďalšie informacie: </h4>
<p>   <?= $post->getMoreinfo() ?> </p>

<?php $login1 = \App\Auth::getName() ?>
<?php $login2 = $post->getLoginfk() ?>

<?php if (strcmp($login1, $login2) != 0 && \App\Auth::isLogged()) { ?>
    <button type="button" style="background-color: #9488ad; border-color: #9488ad; justify-content: center"
            class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Reaguj na ponuku
    </button>
    <?php if($post->getReported() == 0){?>
    <form method="post" action="?c=auth&a=reportOffer">
        <input type="hidden" name="parid" value="<?= $post->getId() ?>">
        <button class="btn btn-primary"  style="margin-left: 10px;background-color: red; border-color: #9488ad; justify-content: center"
                type="submit"
                onclick="return confirm('Ste si istý že chcete nahlásiť tento inzerát?');">

            Nahlásiť inzerát
        </button>
    </form><?php } else {?>
            <br>
        <strong style="color: red"> Tento inzerát bol nahlásený!</strong>

<?php }} else { ?>

    <hr class="solid">

    <form method="post" action="?c=offer&a=deleteOffer">
        <input type="hidden" name="postid" value="<?= $post->getId() ?>">
        <button class="btn btn-primary  text-uppercase fw-bold" type="submit"
                style="background-color: darkviolet; display: inline-block;"
                onclick="return confirm('Ste si istý že chcete zmazať tento inzerát?');">
            Zmazať
        </button>
    </form>
    <form method="post" action="?c=offer&a=editForm">
        <input type="hidden" name="postid" value="<?= $post->getId() ?>">
        <button class="btn btn-primary text-uppercase fw-bold" type="submit"
                style="background-color: darkviolet; display: inline-block;">
            Upraviť
        </button>
    </form>
<?php } ?>

<?php if ($post->getTutor() == 1) { ?>
<hr class="solid">
<br>
<h4>Recenzie na dočovateľa:</h4>
<br>
<div class="container">
    <div class="be-comment-block">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <?php foreach ($data['reviews'] as $review) {
            if ($review->getReceiver() == $post->getLoginfk()) {
                $numReviews++ ?>
                <div class="container mt-5" style="border-bottom-color: #9488ad">
                    <div class="be-comment"
                         style="margin-bottom: 50px !important; border-bottom-color: #9488ad !important">
                        <?php foreach ($data['logins'] as $user) {
                            if ($user->getEmail() == $review->getSender()) {
                                if ($user->getProfilepic() != "") { ?>
                                    <?php if ($user->getProfilepic() != "") { ?>
                                        <img class="pp"
                                             src="<?= \App\Config\Configuration::UPLOAD_DIR . $user->getProfilepic() ?>"
                                             alt="Chyba!">
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="empty_pp"></div>
                                <?php }
                            }
                        } ?></div>
                    <div class="be-comment-content" style="margin: 10px ; border-color: #9488ad">
                                <span class="be-comment-name"><strong
                                            style="margin-left: 1px"><?php echo $review->getSender() ?></strong>
                                </span>
                        <span class="be-comment-time">

					        <?php echo $review->getDateof() ?> <strong style="margin-left: 10px">Hodnotenie:</strong>
                                <?php for ($i = 0; $i < $review->getRating(); $i++) { ?>
                                    ☆
                                <?php } ?>

                            <?php if ($review->getSender() == \App\Auth::getName()) {
                                $numFromUser++;?>
                                <form method="post" action="?c=auth&a=deleteReview">
                        <input type="hidden" name="parid" value="<?= $post->getId() ?>">
                        <input type="hidden" name="rewid" value="<?= $review->getId() ?>">
                                            <button class="btn send btn-primary"
                                                    style=" border-color: transparent; margin-left: 20px"
                                                    type="submit">
                                        <strong style=" text-align: right">Zmazať</strong>
                                    </button>
                                </form>
                            <?php } ?>
                                </span>
                        <p class="be-comment-text">
                            <?php echo $review->getReview() ?>
                        </p>
                    </div>
                </div>

            <?php }
        }
        if ($numReviews == 0) { ?>
            <p>K doučovateľovi neboli zatiaľ pridané žiadne recenzie.</p>
        <?php } ?>
    </div>
    <?php if (strcmp($login1, $login2) != 0 && \App\Auth::isLogged() && $numFromUser == 0 ){ ?>
        <form method="post" action="?c=auth&a=newReview">
            <br>
            <div class="row" style="justify-content: center">
                <div class="col-12">
                    <div class="comment-box ml-5">
                        <h4>Doučoval vás tento používateľ? Zanechajte recenziu</h4>
                        <div class="rating form-group">
                            <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                            <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                            <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                            <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                            <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label></div>
                        <div class="comment-area"><label for="review"></label>
                            <textarea class="form-control" id="review" name="review" placeholder=""
                                      rows="5" required></textarea></div>
                        <input type="hidden" name="sender" value="<?= $login1 ?>">
                        <input type="hidden" name="receiver" value="<?= $login2 ?>">
                        <input type="hidden" name="parid" value="<?= $post->getId() ?>">
                        <div class="comment-btns mt-2">
                            <div class="row">

                                <div class="col-6">
                                    <button type="submit" id="submit" class="btn send btn-primary btn-block">
                                        Odoslať
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form> <?php } if( $numFromUser > 0){?>
        K tomuto užívateľovi ste už pridali recenziu. Pokiaľ sa váš názor zmenil, predchádzajúcu odstránte a zverejnite novú.
    <?php }
    }
    }
    } ?>

</div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="text-align: center">Reakcia na ponuku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="?c=auth&a=sendMessage">

                <!-- Modal body -->
                <div class="modal-body">
                    <label for="comment">Napíšte krátku správu užívateľovi o ponuke:</label>
                    <textarea class="form-control" rows="3" id="message" name="message" required
                              placeholder="Dobrý deň, volám sa <?php echo \App\Auth::getRealName() ?>a zaujala ma Vaša ponuka. Ak je ešte aktuálna, kontaktujte ma prosím na <?php echo \App\Auth::getName() ?>.">Dobrý deň, volám sa <?php echo \App\Auth::getRealName() ?>a zaujala ma Vaša ponuka "<?php echo $post->getTitle() ?>". Ak je ešte aktuálna, kontaktujte ma prosím na <?php echo \App\Auth::getName() ?>.</textarea>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="sender" value="<?= $login1 ?>">
                    <input type="hidden" name="receiver" value="<?= $login2 ?>">
                    <input type="hidden" name="parid" value="<?= $data['parid'] ?>">

                    <button type="submit" id="submit" class="btn btn-dark">Odošli ponuku</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
