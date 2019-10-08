<?php if(!defined('__MAIN__')) header('Location: /'); ?>
<?php if(isset($data)) { ?>
    test
<?php } else { ?>
<?php require_once WEBROOT . '/Components/header.php'; ?>
<?php require_once WEBROOT . '/Components/navbar.php'; ?>

<section>
    <div class="py-3">
        <div class="container">     
            이전에 출제 하였던 문제들을 모아놓은 곳 입니다.<br><br>
            취약점을 찾으신 분께서는 (Kakaotalk: @c2w2m2, Facebook: <a href="https://fb.com/c2w2m2">https://fb.com/c2w2m2</a>)을 통해서 제보해주시면 소정의 상품을 드립니다 :)<br><br>
            서버에 대한 공격행위는 자제해주세요 :(
        </div>
    </div>
</section>

<?php require_once WEBROOT . '/Components/fotter.php'; ?>

<?php } ?>