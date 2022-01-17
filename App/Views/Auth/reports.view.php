<?php /** @var Array $data */ ?>

<?php $numOfReviews = 0 ?>
<?php $numOfOffers = 0 ?>

<div class="main">
    <?php if ($data['note'] != "") { ?>

        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo($data['note']) ?>
        </div>
    <?php } ?>
    <h4 style="text-align: left; font-size: large">Nahlásené recenzie:</h4>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Dátum</th>
            <th scope="col">Príjemca</th>
            <th scope="col">Odosielateľ</th>
            <th scope="col">Recenzia</th>
            <th scope="col" style="color: red">Zmazať</th>
            <th scope="col" style="color: darkblue">Ignorovať</th>


        </tr>
        </thead>
        <tbody>

        <?php foreach ($data['reviews'] as $rewiew) {
        if ($rewiew->getReported() == 1) { ?>

        <tr <?php if ($rewiew->getReceiver() == \App\Auth::getName()) { ?> style="background-color: #e5efff" <?php } ?>>
            <?php $numOfReviews++ ?>
            <?php $login1 = $rewiew->getReceiver() ?>
            <?php $login2 = $rewiew->getSender() ?>

            <th scope="row"><?php echo $numOfReviews ?></th>
            <td><?php echo $rewiew->getDateof() ?></td>
            <td><?php echo $rewiew->getReceiver() ?></td>
            <td><?php echo $rewiew->getSender() ?></td>
            <td><?php echo $rewiew->getReview() ?></td>
            <td>
                <form method="post" action="?c=auth&a=deleteReportedReview">
                    <input type="hidden" name="rewid" value="<?= $rewiew->getId() ?>">
                    <button class="btn btn-primary" style="border-color: transparent"
                            type="submit">
                        Zmaž
                    </button>
                </form>
            </td>
            <td>
                <form method="post" action="?c=auth&a=ignoreReportedReview">
                    <input type="hidden" name="rewid" value="<?= $rewiew->getId() ?>">
                    <button class="btn btn-primary" style=" border-color: transparent"
                            type="submit">
                        Ignoruj
                    </button>
                </form>
            </td>
        </tr>
        </tbody>
        <?php }
        } if ($numOfReviews == 0){ ?>
        <p>Žiadne recenzie neboli nahlásené.
            <?php } ?>

    </table>
    <br>
    <br>
    <h4 style="text-align: left; font-size: large">Nahlásené inzeráty:</h4>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Úžívateľ</th>
            <th scope="col">Inzerát</th>
            <th scope="col" style="color: red">Zmazať</th>
            <th scope="col" style="color: darkblue">Ignorovať</th>


        </tr>
        </thead>
        <tbody>

        <?php foreach ($data['offers'] as $offer) {
        if ($offer->getReported() == 1) {
        $numOfOffers++
        ?>

        <tr>
            <th scope="row"><?php echo $numOfOffers ?></th>
            <td><?php echo $offer->getLoginfk() ?></td>
            <td><form method="post" action="?c=offer&a=singleOffer">
                    <input type="hidden" name="parid" value="<?= $offer->getId() ?>">
                    <button class="btn btn-primary"style="background: none; color:darkblue; border-color: transparent; font-weight: bold " type="submit">
                        <?php echo $offer->getTitle() ?>
                    </button>
                </form></td>
            <td>
                <form method="post" action="?c=auth&a=deleteReportedOffer">
                    <input type="hidden" name="parid" value="<?= $offer->getId() ?>">
                    <button class="btn btn-primary" style="border-color: transparent"
                            type="submit">
                        Zmaž
                    </button>
                </form>
            </td>
            <td>
                <form method="post" action="?c=auth&a=ignoreReportedOffer">
                    <input type="hidden" name="parid" value="<?= $offer->getId() ?>">
                    <button class="btn btn-primary" style=" border-color: transparent"
                            type="submit">
                        Ignoruj
                    </button>
                </form>
            </td>
        </tr>
        </tbody>
        <?php }
        } if ($numOfOffers == 0){ ?>
        <p>Žiadne inzeráty neboli nahlásené.
            <?php } ?>
    </table>
</div>
