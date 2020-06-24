<?
$max_length = 250; $src ='';
if (strlen($printer_model['specfication']) > $max_length){
    $offset = ($max_length - 3) - strlen($printer_model['specfication']);
    $printer_model['specfication'] = substr($printer_model['specfication'], 0, strrpos($printer_model['specfication'], ' ', $offset)) . '...';
}
if (getimagesize(Assets.'images/printer/model/'.$printer_model['image']) !== false) {
    $src = Assets.'images/printer/model/'.$printer_model['image'];
}else{
    $src = Assets.'images/no-image.png';
}



?>

<div class="row">
    <div class="thumbnail ">
        <div class="col-sm-3 m-t-10">
            <div class="">
                <div class="text-center m-t-30"><img width="185" height="auto" src="<?=$src?>" alt="labels Image"></div>
            </div>
        </div>
        <div class="col-sm-5 m-t-10">
            <div class="caption2">
                <h2>
                    <?=$printer_model['Name']?>
                </h2>
                <p class="text-justify"><strong>Compatibility:
                        <?=$printer_model['method']?>
                    </strong><br>
                    <small>
                        <?=$printer_model['specfication']?>
                    </small></p>
                <div class="row">
                    <p class="col-md-6"><strong>Maximum Print Size</strong><br>
                        <?=$printer_model['PrintWidth']?>
                        mm</p>
                    <p class="col-md-6"><strong>Maximum Roll Diameter</strong><br>
                        <?=$printer_model['RollDiamter']?>
                        mm</p>
                    <p class="col-md-6"><strong>Core Size</strong><br>
                        <?=$printer_model['coresize']?>
                    </p>
                    <p class="col-md-6"><strong>Compatibility</strong><br>
                        <?=$printer_model['method']?>
                    </p>
                </div>

                <!--<a rel="nofollow" href="<?=base_url()?>download/printer/<?=$printer_model['pdf']?>" class=" col-xs-12 btn orangeBg" role="button">
      <i class="fa fa-file-pdf-o"></i> Product Data Sheet </a> -->

                <a rel="nofollow" target="_blank" href="<?=base_url()?>download/printer/<?=$printer_model['pdf']?>" class="col-xs-6 btn btn-lg btn-md btn-sm orangeBg pull-right" role="button"> <i class="fa fa-file-pdf-o"></i> Product Datasheet </a> <a rel="nofollow" target="_blank"  href="<?=base_url()?>download/usermanuals/<?=$printer_model['pdf']?>" class="col-xs-5 btn btn-lg btn-md btn-sm orangeBg pull-left" role="button"> <i class="fa fa-file-pdf-o"></i> User Manuals </a> </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 p0 ">
            <div id="carousel">
                <div class="caption2">
                    <div class="">
                        <div class=" ">
                            <div id="fade-quote-carousel" class="carousel carousel3 slide">
                                <!-- Carousel indicators -->
                                <ol class="carousel-indicators">
                                    <li data-slide-to="0" data-target="#fade-quote-carousel" class="active"></li>
                                    <li data-slide-to="1" data-target="#fade-quote-carousel" class=""></li>
                                    <li class="" data-slide-to="2" data-target="#fade-quote-carousel"></li>
                                </ol>
                                <div style="position:absolute; right:0px; top:250px; z-index:1;" class="pull-left">
                                    <!--<a role="button" class="btn orangeBg" ><i class="fa fa-file-pdf-o f-20"></i> </a>-->
                                </div>
                                <div class="pull-right"> </div>
                                <!-- Carousel items -->
                                <h2 class="BlueHeading">Label storage & print performance </h2>
                                <div class="carousel-inner">
                                    <div class="item active ">
                                        <div>
                                            <p class="text-justify"><small> To get the best results from your label printing and achieve a consistent print quality, how you store labels is
                                                    important to avoid variable print quality and maintain operational efficiency. </small> </p>
                                            <p class="text-justify"> <strong>The following guidelines will assist in this aim: </strong><br>
                                            <ul>
                                                <li><small> Always store your labels in a clean dry environment between  5 – 30C (ideally 22C +/- 2C) and a relative humidity of 50% +/-5%.
                                                        The nearer to these conditions the better. E.g. Do not store labels adjacent to a radiator if on, or in a cold and/or damp location. </small></li>
                                            </ul>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="item  " style="line-height:24px;">
                                        <ul>
                                            <li><small>Store in original packaging </small></li>
                                            <li><small>Store away from direct sunlight e.g. Do not store labels on a window sill in summer. </small></li>
                                            <li><small>Rotate stock so that the oldest material is used first. Our labels have a shelf-life of up to 2 years. </small></li>
                                            <li><small>Store rolls of labels horizontally, not vertically. </small></li>
                                            <li><small> Ensure that the winding tension of label rolls is not to tight to prevent adhesive edge bleed. </small></li>
                                        </ul>
                                    </div>
                                    <div class="item  ">
                                        <div>
                                            <p class="text-justify"> <strong>How labels are handled can also have an impact on print outcomes and printer performance: </strong><br>
                                            <ul>
                                                <li><small>Store in original packaging </small></li>
                                                <li><small> Remember that  label rolls are at their most vulnerable on the edges so always handle with care </small></li>
                                                <li><small>Damaged roll edges increase the possibility for printer problems. </small></li>
                                            </ul>
                                            <p class="text-justify"><small> Always inspect rolls of labels to be used in the printer and remove any labels that possibly could have adhesive on the edge of the face stock material. </small></p>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
