
<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header no-bg">

                        <div class="row artwork-details-row">
                            <div class="col-md-3 artwork-details-row-col">
                                <ul class="list-none">
                                    <li>Order No.:</li>

                                    <li>Total Prin Jobs:</li>

                                    <li>Designer:</li>

                                    <li>CC Operator:</li>

                                    <li>Customer/Country:</li>
                                </ul>

                                <ul class="list-none-1">
                                    <li>AA177731 (en)</li>

                                    <li>11 (Rolls) + 8 (A4)</li>

                                    <li>Shahid</li>

                                    <li>Lydie</li>

                                    <li>Paul Mather (UK)</li>
                                </ul>


                            </div>
                            <div class="col-md-3 artwork-details-row-col">

                                <button type="button"
                                        class="btn btn-outline-info waves-light waves-effect artwork-details-row-button">
                                    Add Roll Details
                                </button>

                            </div>
                            <div class="col-md-3 artwork-details-row-col"></div>
                            <div class="col-md-3 artwork-details-row-col"></div>

                        </div>


                    </div>
                    <div class="card-body p-7">


                        <div class="tabs-vertical-env row artwork-row-margin-adjst ">

                            <ul class="nav tabs-vertical ">

                                <?php foreach ($jobs as $job){
                                    $status = $this->Rejected_artwork_model->getJobStatus($job->status);
                                    if($job->action==0){
                                        $lightName = 'red';
                                    }else if($job->action==1){
                                        $lightName = 'green';
                                    }else if($job->action==2){
                                        $lightName = 'yellow';
                                    }
                                    if($job->checklist==0){
                                        $lightName = 'blue';
                                    }

                                    ?>
                                <li class="nav-item artwork-detail-li active">
                                    <a href="#" onclick="changeIntegratedPart('<?=$orderNumber?>',<?=$job->ID?>)" data-toggle="tab" aria-expanded="false"
                                       class="nav-link nav-link">

                                        <div class="sk-spinner sk-spinner-pulse <?=$lightName?>-artwork-pulse"></div>

                                        Print Job No.: <b>Pj<?=$job->ID?></b></a>
                                    <ul class="artwork-detail-ul">
                                        <li class="artwork-sub-text-li">Product Code <p><b><?=$job->diecode?></b></p></li>
                                        <li class="artwork-sub-text-li">Product Code <p><b><?=$job->diecode?></b></p></li>
                                        <li class="artwork-sub-text-li-sub">Sheets/Rolls<p><b><?=$job->qty?></b></p></li>
                                        <li class="artwork-sub-text-li-subs">No. of Labels<p><b><?=$job->labels?></b></p></li>
                                    </ul>
                                    <br />
                                    <br />
                                    <br />
                                 <p><?=$status?></p>
                                </li>

                             <?php }?>

                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane" id="v-home">Test 1</div>
                                <div class="tab-pane active" id="v-profile">





                                </div>
                                <div class="tab-pane" id="v-messages">
                                    <p>Test 3</p>
                                </div>
                                <div class="tab-pane" id="v-settings">
                                    <p>Test 4</p>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <!-- en row -->
    </div>

    <!-- en container -->
</div>
<!-- en wrapper -->
<!-- Footer -->

<script>
    $(document).ready(function () {
        $.ajax({
            type: "get",
            url: mainUrl+'Artworks/integratedPart',
            cache: false,
            data:{'orderNumber':'<?=$orderNumber?>' },
            dataType: 'json',
            success: function(data)
            {
                $('#v-profile').html(data.html);
            },
            error: function(){
                alert('Error while request..');
            }
        });
    });
    function changeIntegratedPart(orderNumber,IntegratedId) {
        $.ajax({
            type: "get",
            url: mainUrl+'Artworks/integratedPart',
            cache: false,
            data:{'orderNumber':orderNumber,IntegratedId:IntegratedId },
            dataType: 'json',
            success: function(data)
            {
                $('#v-profile').empty();
                $('#v-profile').html(data.html);
            },
            error: function(){
                alert('Error while request..');
            }
        });
    }



    function showCommentBox() {
        $('#cm_box').show()
    }
</script>
