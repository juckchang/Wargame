<?php if(!defined('__MAIN__')) header('Location: /'); ?>

<?php require_once WEBROOT . '/Components/header.php'; ?>
<?php require_once WEBROOT . '/Components/navbar.php'; ?>
<?php

    function cmp($a, $b){
        if ($a['point'] == $b['point']) {
            return ($a['time'] < $b['time']) ? -1 : 1;
        }
        return ($a['point'] > $b['point']) ? -1 : 1;
    }

    $users = getUsers();
    $points = [];
    foreach($users as $user){
        $res = query('select sum(challs.point) as point, users.last_solves as time, users.comment as comment from challs, users where challs.no in (select no from solves where id=:id) and visable=1 and users.id=:id_;', [
            ':id' => $user['id'],
            ':id_' => $user['id']
        ]);
        array_push($points, ['id' => $user['id'], 'point' => empty($res['val']['point']) ? 0 : intval($res['val']['point']), 'comment' => $res['val']['comment'], 'time' => $res['val']['time'] ]);
    }
    usort($points, "cmp");
?>
<section>
    <div class="py-3">
        <div class="container">     
            <table class="table" style="text-align: center; table-layout:fixed ">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%"> # </th>
                        <th width="25%"> ID </th>
                        <th width="40%"> comment </th>
                        <th width="20%"> last submit </th>
                        <th width="10%"> points </th>
                    </tr>

                    <?php for($i = 0; $i < count($points); $i++){ ?>
                    <?php if($points[$i]['point'] == 0) break;?>
                        <tr>
                            <td style="text-overflow:ellipsis; overflow:hidden"> <?= $i + 1; ?> </td>
                            <td style="text-overflow:ellipsis; overflow:hidden"> <?= htmlspecialchars($points[$i]['id']); ?> </td>
                            <td style="text-overflow:ellipsis; overflow:hidden"> <?= htmlspecialchars($points[$i]['comment']); ?> </td>
                            <td style="text-overflow:ellipsis; overflow:hidden"> <?= date("Y-m-d h:i:s", $points[$i]['time']); ?> </td>
                            <td style="text-overflow:ellipsis; overflow:hidden"> <?= htmlspecialchars($points[$i]['point']); ?> </td>
                        </tr>
                    <?php } ?>

                </thead>
            </table>
        </div>
    </div>
</section>

<?php require_once WEBROOT . '/Components/fotter.php'; ?>

