<?php if(!defined('__MAIN__')) header('Location: /'); ?>

<?php require_once WEBROOT . '/Components/header.php'; ?>
<?php require_once WEBROOT . '/Components/navbar.php'; ?>
<?php
    $users = getUsers();
?>
<section>
    <div class="py-3">
        <div class="container">     
            <table class="table" style="text-align: center; table-layout:fixed ">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%"> # </th>
                        <th width="95%"> Email </th>
                    </tr>

                    <?php for($i = 0; $i < count($users); $i++){ ?>
                        <tr>
                            <td style="text-overflow:ellipsis; overflow:hidden"> <?= $i + 1; ?> </td>
                            <td style="text-overflow:ellipsis; overflow:hidden"> <?= htmlspecialchars($users[$i]['id']); ?> </td>
                        </tr>
                    <?php } ?>

                </thead>
            </table>
        </div>
    </div>
</section>

<?php require_once WEBROOT . '/Components/fotter.php'; ?>

