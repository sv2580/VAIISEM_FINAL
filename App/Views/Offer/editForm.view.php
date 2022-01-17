<?php /** @var Array $data */ ?>
<?php foreach($data['offers'] as $post) {
if ($post->getId() == $data['postid']) {
    $offer = $post;
}}?>

<script src="public/js/editForm.js"></script>


<div class="row justify-content-center" >

    <?php if ($data['error'] != "") {?>
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Chyba!</strong> <?php echo $data['error'] ?>
        </div>
    <?php } ?>
    <div class="col-md-8">

        <h4 style="text-align: center; font-size: larger">Upravenie ponuky:  "<?= $offer->getTitle()?>"</h4>

        <form method="post" action="?c=offer&a=editOffer">
            <div class="form-group">
                <input type="hidden" name="parid" value="<?=$offer->getId()?>">

                <label for="title">Nadpis:</label>
                <input type = "text" name="title" class="form-control"  id="title" value="<?= $offer->getTitle()?>" required>
                <small id="titleHelp" class="form-text text-muted">Zadajte nadpis vašej ponuky, napríklad "Doučím: Jazyk PHP"</small>
            </div>
            <br>

            <div class="form-group">
                <label for="info">Stručné informácie:</label>
                <input type = "text" name="info" class="form-control" id="info" value="<?= $offer->getInfo()?>" required>
                <small id="infoHelp" class="form-text text-muted">Zadajte základné informácie k doučovaniu, ktoré budú zobrazené na hlavnej stránke.</small>

            </div>
            <br>
            <div class="form-group">
                <label for="info">Informácie:</label>
                <input type = "text" name="moreinfo" class="form-control"  id="moreinfo" value="<?= $offer->getMoreinfo()?>" required>
                <small id="moreinfoHelp" class="form-text text-muted">Zadajte ďalšie potrebné informácie, vaše požiadavky a podobne.</small>

            </div>
            <br>

            <div class="form-group">
                <label for="place">Miesto:</label>
                <input type = "text" name="place"  class="form-control"  id="place" value="<?= $offer->getPlace()?>" required>
                <small id="placeHelp" class="form-text text-muted">Zadajte požiadavku na miesto doučovania. Môže to byť online, konkrétne mesto...</small>
            </div>
            <br>
            <div class="form-group">
                <label for="place">Plat:</label>
                <input type = "text" name="pay"  class="form-control" id="pay" value="<?= $offer->getPay()?>" required>
                <small id="payHelp" class="form-text text-muted">Zadajte požiadavku na plat/bez platu.</small>
            </div>
            <br>
            <div class="form-group">
                <label for="education">Dosiahnuté vzdelanie :</label>
                <select class="form-select mt-3" name="education" id="education" value="<?= $offer->getEducation()?>">
                    <option>Základné vzdelanie</option>
                    <option>Stredoškolské s maturitou</option>
                    <option>Stredoškolské bez maturity</option>
                    <option>Nadstavbové/vyššie odborné</option>
                    <option>Vysokoškolské I. stupňa</option>
                    <option>Vysokoškolské II. stupňa</option>
                    <option>Vysokoškolské III. stupňa</option>
                </select>

            </div>

            <br>
            <div class="form-group">
                <label for="courses">Kurzy,certifikáty:</label>
                <input type = "text"  value="<?= $offer->getCourses()?>" name="courses"  class="form-control"  id="courses" >
                <small id="coursesHelp" class="form-text text-muted">Tu môžete zadať svoje kurzy a certikáty.</small>
            </div>
            <br>
            <div class="form-group">
                <label for="email">Emailová addresa: </label>
                <input type="email" value="<?= $offer->getContact() ?> "  name="contact" class="form-control" id="email" aria-describedby="emailHelp" placeholder="<?= $offer->getContact() ?> " required>
                <small id="emailHelp" class="form-text text-muted">Zadajte e-mailovú adresu, na ktorú chcete, aby vás záujemcovia kontaktovali.
                    Nemusí sa zhodovať s adresou prihlásenia.</small>
            </div>
            <br>
            <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Upravte ponuku
                </button>
            </div>
        </form>
    </div></div>