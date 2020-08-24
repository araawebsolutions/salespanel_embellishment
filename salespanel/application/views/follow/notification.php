
<div class="slimScrollDiv">

    <div class="slimscroll" style="max-height: 230px; overflow-y: scroll; width: auto; height: 1039px;">

        <!-- item-->

        <?php foreach ($notifications as $notification){?>

        <a href="javascript:void(0);" class="dropdown-item notify-item">

            <div class="notify-icon bg-success"><i class="mdi mdi-comment-account-outline"></i></div>

            <p class="notify-details"><?=$notification->comment?></p>

        </a>

        <!-- item-->

        <?php }?>



    </div>

    <div class="slimScrollBar" style="background: rgb(158, 165, 171); width: 8px; position: absolute; top: 179px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 51.2597px;"></div>

    <div class="slimScrollRail" style="width: 8px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>

</div>