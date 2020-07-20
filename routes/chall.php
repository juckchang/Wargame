<?php if(!defined('__MAIN__')) header('Location: /'); ?>
<?php if(!checkLogin()) header('Location: /'); ?>
<?php if(isset($data)) { ?>
    <?php
        $no = intval($data['no']);
        $flag = trim($data['flag']);

        if(checkSolved($no)){
            $check = checkFlag($no, $flag);
            insertSubmission($check, $no, $flag);
            if($check){
                insertSolve($no, $flag);
                updateUser();
                die('{"success":1, "msg":"축하드립니다! 문제를 푸셨습니다!"}');
            }else{
                die('{"success":0, "msg":"잘못된 플래그입니다."}');
            }
        }else{
            die('{"success":0, "msg":"이미 풀린 문제입니다."}');
        }

    ?>
<?php } else { ?>

<?php require_once WEBROOT . '/Components/header.php'; ?>
<?php require_once WEBROOT . '/Components/navbar.php'; ?>

<section>
    <div class="py-3">
        <div class="container">     
            <?php 
                $categorys = getCategorys();
                foreach($categorys as $category){
            ?>
                <div class="chall-box">
                    <h3><?= htmlspecialchars($category['category']); ?></h3>
                    <hr>
                    <?php 
                        $challs = getChalls($category['category']);
                        foreach($challs as $chall){
                            $uploads = getUploads($chall['no']);
                    ?>
                        <div class="card <?= checkSolved($chall['no']) ? "bg-light" : "bg-success"  ?> chall" style="width: 15%; height: 15%; float: left; margin-left: 1%; margin-bottom:1%;">
                            <div class="card-body text-center">
                                <p class="card-text challenge-title"><?= $chall['title'] ?></p>
                                <p class="card-text challenge-point"><?= $chall['point'] ?></p>
                            </div>
                            <div style="display: none;" class="challenge-no"><?= $chall['no'] ?></div>
                            <div style="display: none;" class="challenge-description"><?= $chall['description'] ?></div>
                            <div style="display: none;" class="challenge-category"><?= $chall['category'] ?></div>
                            <div style="display: none;" class="challenge-solvers"><?= getSolvers($chall['no']) ?></div>
                            <?php
                                foreach($uploads as $upload){
                            ?>
                                <div style="display: none;" class="challenge-upload"><?= $upload['path']; ?></div>
                            <?php } ?>
                        </div>
                        
                    <?php }?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<div class="modal fade challenge" id="challenge" tabindex="-1" role="dialog" aria-labelledby="challenge" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="challenge"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-description"></div>
            <div class="modal-footer" style="justify-content: flex-start">
                <div class="form-group" style="width:100%">
                    <input type="text" class="form-control" aria-describedby="flagHelp" placeholder="DIMI{~~~}" id="flag">
                    <span id="flagHelp" class="form-text" style="color: rgb(108, 117, 125); display:none; font-size: 12px;">플래그를 입력해주세요.</span>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" class="modal-no"></div>
</div>

<script>
    window.onload = () => {
        $('.chall').on('click', function() {
            let solver = parseInt($(this).find('.challenge-solvers').html())
            let title = $(this).find('.challenge-title').html()
            title += ' <span style="font-size:14px;">' + (solver == 0 ? 'Not solve yet' : `${solver} solved`) + '</span>'
            $('.modal-title').html(title)
            $('.modal-description').html($(this).find('.challenge-description').html() + '<br><br>')
            if($(this).find('.challenge-upload').length != 0){
                $(this).find('.challenge-upload').each((idx, item) => {
                    let link = item.innerHTML
                    let fname = link.split('/').pop()
                    let html = `<a href="${link}" target="_blank">${fname}</a>&nbsp;&nbsp;`
                    $('.modal-description').html($('.modal-description').html() + html)
                })
            }
            $('.modal-no').html($(this).find('.challenge-no').html())
            if($(this).attr('class') == 'card bg-success chall'){
                $('.modal-footer').css('display', 'none')
            }else{
                $('#flag').val('')
                $('#flagHelp').css('display', 'none')
            }
            $('.challenge').modal()
        })

        $('#flag').keydown(async function(key) {
            if (key.keyCode == 13) {
                if(/DIMI{(.*)}/.exec($('#flag').val()) == null){
                    $('#flagHelp').html('플래그 형식에 맞춰주세요.')
                    $('#flagHelp').css('color', 'red')
                    $('#flagHelp').css('display', 'inline')
                }else{
                    $('#flagHelp').css('display', 'none')
                    let response = await axios.post('/chall',{
                        no: $('.modal-no').html(),
                        flag: $('#flag').val()
                    })
                    if(response.data.success){
                        $('#flagHelp').html(response.data.msg)
                        $('#flagHelp').css('color', 'green')
			$('#flagHelp').css('display', 'inline')
		    	setTimeout(()=>window.location.reload(false), 500)
		    }else{
                        $('#flagHelp').html(response.data.msg)
                        $('#flagHelp').css('color', 'rgb(108, 117, 125)')
                        $('#flagHelp').css('display', 'inline')
                    }
                }
                $('#flag').val('')
            }
        })
    }
</script>

<?php require_once WEBROOT . '/Components/fotter.php'; ?>

<?php } ?>
