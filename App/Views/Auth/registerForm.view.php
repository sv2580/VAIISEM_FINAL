<?php /** @var Array $data */ ?>
<script src="public/js/registerForm.js"></script>

<div class="row justify-content-center" >
    <div class="col-md-6">
        <div class="card">
            <h2 style="text-align: center">Registračný formulár</h2>
            <article class="card-body">
                <form method="post" enctype="multipart/form-data" action="?c=auth&a=register">
                    <?php if ($data['error'] != "") {?>
                        <div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Chyba!</strong> <?php echo $data['error']?>
                        </div>
                    <?php } ?>
                    <div class="form-row">
                        <div class="col form-group">
                            <label>Meno </label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="" required >
                        </div>
                        <div class="col form-group">
                            <label>Priezvisko</label>
                            <input type="text" id="surname" name="surname" class="form-control" placeholder=" " required>
                        </div>
                        <div class="col form-group">
                            <label>Rok narodenia</label>
                            <input type="number" id="birthyear" name="birthyear" class="form-control" placeholder=" " required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Emailová adresa</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="" required>
                        <small class="form-text text-muted"></small>
                    </div>

                    <div class="form-group">
                        <label>Heslo</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder=" " required>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Profilová fotka:</label>
                        <input name="file"  accept="image/*" class="form-control" id="formFile" onchange="fileValidation()" type="file">
                    </div>
                    <small class="text-muted">Profilová fotka nie je povinná, ale zvyšuje Vaše šance na reakcie.</small>

                    <br>
                    <div id="submit-info">
                        Zadajte všetky údaje v správnom tvare!
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit" class="btn btn-primary btn-block"> Registrovať</button>
                    </div>
                    <small class="text-muted">Kliknutím na tlačidlo 'Registrovať' potvrdzujete, že súhlasíte s podmienkami používania.</small>
                </form>
            </article>
            <div class="border-top card-body text-center">Už máte účet? <a href="?c=auth&a=loginForm">Prihláste sa.</a></div>
        </div>
    </div>

</div>


