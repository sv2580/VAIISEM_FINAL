<?php /** @var Array $data */ ?>

<?php $numOfUsers = 0 ?>

<div class="main">
    <?php if ($data['note'] != "") { ?>

        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo($data['note']) ?>
        </div>
    <?php } ?>
    <h4 style="text-align: left; font-size: large">Zoznam užívateľov:</h4>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">E-mail</th>
            <th scope="col">Počet nahlásení</th>
            <th scope="col" style="color: red">Zmazať účet</th>


        </tr>
        </thead>
        <tbody>

        <?php foreach ($data['logins'] as $login) { ?>

        <tr <?php if($login->getReports() == 1){ ?>
            style="background-color: #ffedea"
        <?php } else if($login->getReports() >= 2){ ?>
            style="background-color: #f6c4ce"
        <?php } ?>
        >
            <?php $numOfUsers++ ?>

            <th scope="row"><?php echo $numOfUsers ?></th>
            <td<?php if($login->getEmail() == \App\Auth::getName()){ ?>
                    style="font-weight: bold"
            <?php }?> > <?php echo $login->getEmail() ?></td>
            <td><?php echo $login->getReports() ?></td>


            <td>
                <form method="post" action="?c=auth&a=deleteUser">
                    <input type="hidden" name="userId" value="<?= $login->getId() ?>">
                    <button class="btn btn-primary" style="border-color: transparent"
                            type="submit"  <?php if($login->getEmail() == \App\Auth::getName()){ ?> disabled <?php }?> >
                        Zmaž
                    </button>
                </form>
            </td>

        </tr>
        </tbody>
        <?php
        } if ($numOfUsers == 0){ ?>
        <p>Žiadne recenzie neboli nahlásené.
            <?php } ?>

    </table>
    <br>
</div>
