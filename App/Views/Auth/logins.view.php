<?php /** @var Array $data */ ?>
<script src="public/js/ajaxDelete.js"></script>

<?php $numOfUsers = 0 ?>

<div class="main">
    <?php if ($data['note'] != "") { ?>

        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo($data['note']) ?>
        </div>
    <?php } ?>
    <input hidden id="admin" value="<?= \App\Auth::getName() ?>">
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
        <tbody id = "tableu">



        </tbody>
    </table>
    <br>
</div>
