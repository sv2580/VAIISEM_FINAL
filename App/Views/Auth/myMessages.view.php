<?php /** @var Array $data */ ?>

<?php $pocetSprav=0?>

<div class="main">
    <h4 style="text-align: left; font-size: large">Reakcie na Vaše ponuky a Vaše reakcie na ponuky iných:</h4>
    <br>
    <?php if ($data['note'] != "") {?>

        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo ($data['note']) ?>
        </div>
    <?php } ?>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Dátum</th>
            <th scope="col">Príjemca</th>
            <th scope="col">Odosielateľ</th>
            <th scope="col">Správa</th>
            <th scope="col">Zmazať</th>
            <th scope="col">Odpovedať</th>


        </tr>
        </thead>
        <tbody>

        <?php foreach ($data['message'] as $mes) {
        if($mes->getSender() == \App\Auth::getName() || $mes->getReceiver() == \App\Auth::getName()) {?>

        <tr  <?php  if($mes->getReceiver() == \App\Auth::getName()) {?> style="background-color: #e5efff" <?php } ?>
            <?php  if($mes->getReceiver() == 'ADMIN' || $mes->getSender() == 'ADMIN') {?> style="background-color: #daf6ed" <?php } ?>
        >
            <?php  $pocetSprav++?>
            <?php $login1 = $mes->getReceiver()?>
            <?php $login2 = $mes->getSender()?>

            <th scope="row" ><?php echo $pocetSprav ?></th>
            <td><?php echo $mes->getDateOfMessage() ?></td>
            <td><?php echo $mes->getReceiver() ?></td>
            <td><?php echo $mes->getSender() ?></td>
            <td><?php echo $mes->getMessage() ?></td>
            <td><form method="post" action="?c=auth&a=deleteMessage">
                    <input type="hidden" name="parid" value="<?= $mes->getId() ?>">
                    <button class="btn btn-primary"style="background: none; color:#333333; border-color: transparent" type="submit">
                        Zmaž
                    </button>
                </form></td>
            <?php if($mes->getSender() != \App\Auth::getName()){?>
                <td><button type="button"  style="background: none; color:#333333; border-color: transparent"
                            class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                        Odpovedať</td>
            <?php } else {?>
                <td></td>
            <?php } ?>
        </tr>
        </tbody>
        <?php }
        if(($mes->getSender() == 'ADMIN' || $mes->getReceiver() == 'ADMIN'))  {?>

            <tr style="background-color: #daf6ed"  <?php  if($mes->getReceiver() == \App\Auth::getName()) {?> style="background-color: #e5efff" <?php } ?>>
                <?php  $pocetSprav++?>
                <?php $login1 = $mes->getReceiver()?>
                <?php $login2 = $mes->getSender()?>

                <th scope="row" ><?php echo $pocetSprav ?></th>
                <td><?php echo $mes->getDateOfMessage() ?></td>
                <td><?php echo $mes->getReceiver() ?></td>
                <td><?php echo $mes->getSender() ?></td>
                <td><?php echo $mes->getMessage() ?></td>
                <td><form method="post" action="?c=auth&a=deleteMessage">
                        <input type="hidden" name="parid" value="<?= $mes->getId() ?>">
                        <button class="btn btn-primary"style="background: none; color:#333333; border-color: transparent" type="submit">
                            Zmaž
                        </button>
                    </form></td>
                <?php if($mes->getSender() != 'ADMIN'){?>
                    <td><button type="button"  style="background: none; color:#333333; border-color: transparent"
                                class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                            Odpovedať</td>
                <?php } else {?>
                    <td></td>
                <?php } ?>
            </tr>
            </tbody>
        <?php }
        } if($pocetSprav == 0){?>
        <p>Nedostali ste žiadne reakcie na ponuky, ani ste na žiadnu ponuku nereagovali.
            <?php } ?>
    </table>
</div>



<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="text-align: center">Reakcia na správu</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="?c=auth&a=sendMessage">

                <!-- Modal body -->
                <div class="modal-body">
                    <label for="comment">Odpovedajte užívateľovi na správu:</label>
                    <textarea class="form-control" rows="3" id="comment" name="message"
                    ></textarea>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="sender" value="<?= $login1 ?>">
                    <input type="hidden" name="receiver" value="<?= $login2 ?>">

                    <button type="submit" id="submit" class="btn btn-dark">Odošli ponuku</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>