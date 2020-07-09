<div class="label-embellishment-small-container-bg mt-10">
    <div class="row">

        <div class="col-md-8  ">
            <span class="label-embellishment-small-text">
                        Upload now or select option to “Artwork to follow”
                        (Maximum 50 designs.)
                    </span>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <a href="#" id="about_your_artwork_cta" style="width: 100% !important;" class="label-embellishment-cta-adjusted" data-toggle="modal" data-target="#artworkuploadpopup">
                About your Artworks <i class="fa fa-chevron-right">
                </i>
            </a>
        </div>




        <div class="col-md-8  ">
            <span class="label-embellishment-small-text">
                        Using our expert graphic designers to create
                        excellent designs for your product.
                    </span>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <a href="#"  style="width: 100% !important;" class="label-embellishment-cta-adjusted"> Inhouse Design Services <i class="fa fa-chevron-right"> </i>
            </a>
        </div>
    </div>
</div>
<?php if ($preferences['available_in'] == "Roll" and $preferences['categorycode_roll'] != ''){ ?>
    <div class="label-embellishment-small-container-bg mt-10">
        <div class="row">


            <div class="margin-top-20" style="padding: 0px 7.5px;">
                <input type="checkbox"

                    <?php if($prices['presproof_charges'] >0){ echo "checked"; } ?> id="press_proof" />
                <label for="press_proof">
                    <span class="labels-embelishemnt-pressproof">Do you require a hard copy pre-production press proof? (Cost £50.00) <br></span>
                    <span class="labels-embelishemnt-pressproof-detail">You will always automatically receive an electronic free of charge soft proof for approval before your labels
                                            are produced.</span>
                </label>
            </div>



        </div>

    </div>
<?php } ?>

</div>
