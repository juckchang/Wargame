<?php if(!defined('__MAIN__')) header('Location: /'); ?>
<?php if(checkLogin()) header('Location: /'); ?>
<?php if(isset($data)) { ?>

<?php 
    if( isset($data['id']) && isset($data['pw']) && isset($data['comment']) ){
        $id = $data['id'];
        $pw = $data['pw'];
        $comment = $data['comment'];

        if(strlen($id) > 32 || strlen($comment) > 256){
            die('{"success":0}');
        }
        
        $res = insertUser($id, $pw, $comment);
        
        if( $res == 0 ){
            die('{"success":0}');
        }else{
            die('{"success":1}');
        }
    }else{
        die('{"success":0}');
    }
    
?>

<?php } else { ?>

<?php require_once WEBROOT . '/Components/header.php'; ?>
<?php require_once WEBROOT . '/Components/navbar.php'; ?>

<section>
    <div class="py-3">
        <div class="container">       
            <form>
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" aria-describedby="idHelp" placeholder="아이디를 입력해주세요." id="id">
                    <p id="idHelp" class="form-text" style="color: rgb(108, 117, 125); display:none;">아이디를 입력해주세요.</p>
                </div>
                <div class="form-group">
                    <label for="pw">PW</label>
                    <input type="password" class="form-control" aria-describedby="pwHelp" placeholder="비밀번호를 입력해주세요." id="pw">
                    <p id="pwHelp" class="form-text"  style="color: rgb(108, 117, 125); display:none;">비밀번호를 입력해주세요.</p>
                </div>
                <div class="form-group">
                    <label for="comment">COMMENT</label>
                    <input type="text" class="form-control" aria-describedby="commentHelp" placeholder="한줄소개를 입력해주세요." id="comment">
                    <p id="commentHelp" class="form-text"  style="color: rgb(108, 117, 125); display:none;">한줄소개를  입력해주세요.</p>
                </div>
                <button type="button" class="btn btn-primary" id="submit">Submit</button>
                <p id="loginHelp" class="form-text"  style="color: red; display:none;">회원가입에 실패했어요.</p>
            </form>

            <script>
                window.onload = () => {
                    $('#comment').keydown(key => {
                        if (key.keyCode == 13) {
                            $('#submit').click()
                        }
                    })

                    $('#submit').on('click', async () => {
                        $('#loginHelp').css('display', 'none')
                        if($('#pw').val().length < 6){
                            $('#pwHelp').html('6글자 이상으로 해주세요.')
                            $('#pwHelp').css('color', 'red')
                            $('#pwHelp').css('display', 'block')
                        }else if($('#comment').val().length > 256){
                            $('#pwHelp').css('display', 'none')
                            $('#commentHelp').html('256글자 이하로 해주세요.')
                            $('#commentHelp').css('color', 'red')
                            $('#commentHelp').css('display', 'block')
                        } else {
                            $('#pwHelp').css('display', 'none')
                            $('#commentHelp').css('display', 'none')
                            let response = await axios.post('/register', {
                                id: $('#id').val(),
                                pw: $('#pw').val(),
                                comment: $('#comment').val()
                            })
                            if(response.data.success){
                                location.href='/login';
                            }else{
                                $('#loginHelp').css('display', 'block')
                            }
                        }
                    })
                }
            </script>
        </div>
    </div>
</section>
<?php require_once WEBROOT . '/Components/fotter.php'; ?>

<?php } ?>
