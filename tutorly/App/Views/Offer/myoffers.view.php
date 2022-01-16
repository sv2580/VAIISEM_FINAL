<?php /** @var Array $data */ ?>

<?php $pocetInzeratov = 0 ?>

<div class="main">
    <?php if ($data['note'] != "") { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $data['note'] ?>
        </div>
    <?php } ?>
    <?php if ($data['error'] != "") { ?>
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Chyba!</strong> <?php echo $data['error'] ?>
        </div>
    <?php } ?>
    <h4 style="text-align: left; font-size: larger">Moje ponuky:</h4>

    <div class="container mt-5">
        <div class="row" style="justify-content: left">
            <?php foreach ($data['offers'] as $post) {
                if ($post->getLoginfk() == $_SESSION["name"]) {
                    $pocetInzeratov++ ?>
                    <div class="col-md-3">
                        <br>
                        <?php if($post->getReported() == 1){?>
                            <strong style="color: red"> Tento inzerát bol nahlásený!</strong>
                        <?php } ?>
                        <form method="post" action="?c=offer&a=singleOffer">
                            <input type="hidden" name="parid" value="<?= $post->getId() ?>">
                            <button class="btn btn-primary  text-uppercase fw-bold"
                                    style="background: none; color:#64496d; border-color: white"
                                    type="submit">
                                <?= $post->getTitle() ?>
                            </button>
                        </form>
                        <p><?= $post->getInfo() ?></p>


                        <form method="post" action="?c=offer&a=deleteOffer">
                            <input type="hidden" name="postid" value="<?= $post->getId() ?>">
                            <button class="btn btn-primary  text-uppercase fw-bold" type="submit"
                                    style="background-color: darkviolet; display: inline-block;"
                                    onclick="return confirm('Ste si istý že chcete zmazať tento inzerát?');">
                                Zmaž
                            </button>
                        </form>
                        <form method="post" action="?c=offer&a=editForm">
                            <input type="hidden" name="postid" value="<?= $post->getId() ?>">
                            <button class="btn btn-primary text-uppercase fw-bold" type="submit"
                                    style="background-color: darkviolet; display: inline-block;">
                                Uprav
                            </button>
                        </form>


                    </div>

                <?php }
            }
            if ($pocetInzeratov == 0) { ?>
                Nemáte žiadne ponuky
            <?php } ?>

        </div>
    </div>
    <p></p>
    <hr class="solid">
    <br>

    <?php $numReviews = 0 ?>
    <div class="be-comment-block">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <?php foreach ($data['reviews'] as $review) {
        if ($review->getReceiver() == \App\Auth::getName()) {
            $numReviews++;
            if ($numReviews == 1) { ?>
                <h4>Recenzie na Vaše doučovanie:</h4>
                Pokiaľ nie je podľa Vás niektorá z recenzií pravdivá, alebo je nevhodná, môžete ju nahlásiť adminovi.
                <br>
            <?php } ?>
            <div class="container mt-5" style="border-bottom-color: #9488ad">
            <div class="be-comment"
                 style="margin-bottom: 50px !important; border-bottom-color: #9488ad !important">

            <div class="empty_pp"
                 style="border-color: #f1f1f1; border-style: solid; border-width: 1px;  "></div>
            <div class="be-comment-content" style="margin: 10px ; border-color: #9488ad">
            <span class="be-comment-name"><strong><?php echo $review->getSender() ?></strong> 	</span>
            <span class="be-comment-time">

					<?php echo $review->getDateof() ?> <strong>Hodnotenie:</strong>

                                <?php for ($i = 0; $i < $review->getRating(); $i++) { ?>
                                    ☆
                                <?php } ?>
                                </span>

            <p class="be-comment-text">
                <?php echo $review->getReview() ?>
            </p>
            <?php if ($review->getReported() == 0) { ?>
                <form method="post" action="?c=auth&a=reportReview">
                    <input type="hidden" name="rewid" value="<?= $review->getId() ?>">
                    <button class="btn send btn-primary"
                            style=" border-color: transparent; background-color: red"
                            type="submit"
                            onclick="return confirm('Ste si istý že chcete nahlásiť túto recenziu?')">
                        <strong style=" text-align: right">Nahlásiť</strong>
                    </button>
                </form> <?php } else {?>
                <strong style="color: red"> Táto recenzia bola nahlásená. </strong>
                <?php } ?>
                </div>
                </div>
                </div>
            <?php }
        }
        if ($numReviews == 0) { ?>
            <p>Neboli k vám priradené žiadne recenzie</p>
        <?php } ?>


    </div>

