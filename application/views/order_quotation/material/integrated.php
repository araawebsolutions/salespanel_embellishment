<link href="<?= Assets ?>labelfinder/css/filters.css" rel="stylesheet">
<script src="<?= Assets ?>labelfinder/js/jquery-ui.js"></script>
<div id="aa_loader" class="white-screen" style="display:none;">
    <div class="loading-gif text-center" style="top:50%; z-index:150;"><img src="<?= Assets ?>images/loader.gif"
                                                                            class="image"
                                                                            style="width:160px; height:43px; "></div>
</div>
<div class="container m-t-b-8 ">
    <div class="row">
        <div class="col-xs-12  col-sm-6 col-md-8 ">
            <ol class="breadcrumb  m0">
                <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i></a></li>
                <li class="active">Integrated Labels</li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 ">
            <div class="pull-right"><a role="button" rel="nofollow" class="btn orangeBg"
                                       href="<?= base_url() . "virtual-catalogue/"; ?>"> <i class="fa fa-desktop"></i>
                    Virtual Catalogue </a></div>
        </div>
    </div>
</div>
<? $url = uri_string();
$category = 'Integrated';
$shape = '';
if (preg_match('/single-integrated-labels/i', $url)) {
    $shape = 'Single Integrated';
} else if (preg_match('/double-integrated-labels/i', $url)) {
    $shape = 'Double Integrated';
} else if (preg_match('/triple-integrated-labels/i', $url)) {
    $shape = 'Triple Integrated';
}
?>
<div class="printed-lba-a4 integrated_header_bg">
    <div class="container ">
        <div class="col-md-8 col-sm-12  ">
            <h1>
                <?= ($shape == '') ? 'Blank and Custom Integrated Labels' : $shape . ' Labels' ?>
            </h1>
            <p class="text-justify">Efficiency gains for businesses are important and streamlining procedures for busy
                catalogue, e-commerce and e-retailers, picking, packing and shipping processes are enabled through the
                use of integrated labels. This simple paper and label combinations, saves order-processing time,
                improves order/shipment accuracy and labour efficiency. In addition using a returns label as part of the
                despatch documentation can enhance customer trust and brand loyalty.</p>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="row integrated_header_logos">
                <? foreach ($compatible_list as $row) { ?>
                    <div class="col-xs-2 col-md-4">
                        <div class="whiteBg"><a
                                    href="<?= base_url() ?>integrated-labels/<?= str_replace(" ", "-", strtolower($row->name)) ?>/">
                                <img width="auto" height="auto" src="<?= Assets ?>images/icons/<?= $row->image ?>"
                                     alt="<?= $row->name ?>" class="img-responsive"> </a></div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>
<div class="bgGray">
    <div class="container">
        <?php
        //include(APPPATH.'/views/labelfinder/label_filters.php')?>

        <!--<div class="filter-margin"></div>-->

        <div class="thumbnail">
            <div class="text-center">
                <div class="m-t-10 image-t-15"><a role="button" class="btn blueBg m-t-15"
                                                  href="<?= base_url() ?>single-integrated-labels/">Single Integrated
                        Labels</a> <a role="button" class="btn blueBg  m-t-15"
                                      href="<?= base_url() ?>double-integrated-labels/">Double Integrated Labels</a>
                    <div class="clear hidden-lg hidden-md"></div>
                    <a role="button" class="btn blueBg  m-t-15" href="<?= base_url() ?>triple-integrated-labels/">Triple
                        Integrated Labels</a> <a role="button" class="btn blueBg  m-t-15"
                                                 href="<?= base_url() ?>full-sheet-integrated-labels/">Full Sheet
                        Delivery Labels</a> <a role="button" class="btn blueBg  m-t-15"
                                               href="<?= base_url() ?>integrated-labels">All Integrated Labels</a></div>
            </div>
        </div>
        <div id="ajax_model_desc"></div>
        <?php if (preg_match('/Full Sheet/', $catdata['CategoryName'])): ?>
            <div class="col-md-12">
                <div class="panel row">
                    <div class="col-md-12">
                        <div class="col-md-12 col-xs-12">
                            <h2 style="font-size: 20px;">Full Sheet Delivery, Pick & Pack, Shipping Labels
                                <small>(A range of full A4 sheet labels with a removable section in the position
                                    indicated)
                                </small>
                            </h2>
                            <p>Although not technically an integrated label (label and paper combined), the listed full
                                sheet delivery labels below, provide the same functionality but with the added benefit
                                of being available in the complete range of material and adhesive options.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div id="ajax_material_sorting">
            <div class="row">
                <? foreach ($integrate['list'] as $pro) {

                    $image = explode(".", $pro->CategoryImage);
                    $imagename = $image[0] . "_1.png";
                    if ($pro->Shape == 'Full Sheet Integrated') {
                        $size = $pro->LabelWidth . ' x ' . $pro->LabelHeight;
                        $product_a4 = $this->home_model->get_equivalent_id($size);
                        $link = "a4-sheets/rectangle/" . strtolower($product_a4->CategoryID) . "/?productid=" . $product_a4->ProductID;
                        $pro->ManufactureID = $product_a4->ManufactureID;
                    } else {
                        $link = 'onclick="getIntegratedDetail(' . "'" . strtolower($pro->CategoryID) . "'" . ')"';
                    }
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 ">
                        <div class="thumbnail">
                            <div class="imgBg text-center"><img id="int_<?= $pro->CategoryID ?>" alt="<?= $imagename ?>"
                                                                title="<?= $pro->CategoryImage; ?>"
                                                                src="<?= Assets . "images/categoryimages/Integrated/" . $pro->CategoryImage; ?>">
                                <div class="pull-left" style="position:absolute; left:5px; top:114px;"><a
                                            id="<?= $pro->CategoryID ?>" class="btn blueBg" href="javascript:void(0);"
                                            data-toggle="tooltip" title="Rotate Image"><i class="fa fa-retweet"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h2>
                                    <?= $pro->Shape ?>
                                    Labels </h2>
                                <p>
                                    <?= $pro->ProductName ?>
                                </p>
                                <div class="row">
                                    <p class="col-md-7 col-sm-7"><strong>Label Size</strong><br>
                                        <?= $pro->LabelWidth ?>
                                        x
                                        <?= $pro->LabelHeight ?>
                                    </p>
                                    <p class="col-md-5 col-sm-5"><strong>Item Code</strong><br>
                                        <?= $pro->ManufactureID ?>
                                    </p>
                                </div>
                                <a href="#" <?= $link ?> class="btn-block btn orange" role="button"><i
                                            class="fa fa-arrow-circle-right"></i> Select </a></div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <? if (empty($compatible) and count($fullsheet['list']) > 0 and 1 == 2) { ?>
                <div class="panel row">
                    <div class="col-md-12">
                        <div class="col-md-12 p0 col-xs-12">
                            <h2 style="font-size: 20px;">Full Sheet Delivery, Pick & Pack, Shipping Labels
                                <small>(A range of full A4 sheet labels with a removable section in the position
                                    indicated)
                                </small>
                            </h2>
                            <p>Although not technically an integrated label (label and paper combined), the listed full
                                sheet delivery labels below, provide the same functionality but with the added benefit
                                of being available in the complete range of material and adhesive options.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <? foreach ($fullsheet['list'] as $pro) {

                            $image = explode(".", $pro->CategoryImage);
                            $imagename = $image[0] . "_1.png";
                            if ($pro->Shape == 'Full Sheet Integrated') {
                                $size = $pro->LabelWidth . ' x ' . $pro->LabelHeight;
                                $product_a4 = $this->home_model->get_equivalent_id($size);
                                $link = "a4-sheets/rectangle/" . strtolower($product_a4->CategoryID) . "/?productid=" . $product_a4->ProductID;
                                $pro->ManufactureID = $product_a4->ManufactureID;
                            } else {
                                $link = 'onclick="getIntegratedDetail(' . "'" . strtolower($pro->CategoryID) . "'" . '"';
                            }
                            ?>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 ">
                                <div class="thumbnail">
                                    <div class="imgBg text-center"><img id="int_<?= $pro->CategoryID ?>"
                                                                        alt="<?= $imagename ?>"
                                                                        title="<?= $pro->CategoryImage; ?>"
                                                                        src="<?= Assets . "images/categoryimages/Integrated/" . $pro->CategoryImage; ?>">
                                        <div class="pull-left" style="position:absolute; left:5px; top:114px;"><a
                                                    id="<?= $pro->CategoryID ?>" class="btn blueBg"
                                                    href="javascript:void(0);" data-toggle="tooltip"
                                                    title="Rotate Image"><i class="fa fa-retweet"></i></a></div>
                                    </div>
                                    <div class="caption">
                                        <h2>Single Full Sheet Integrated Label </h2>
                                        <p>
                                            <?= $pro->ProductName ?>
                                        </p>
                                        <div class="row">
                                            <p class="col-md-7"><strong>Label Size</strong><br>
                                                <?= $pro->LabelWidth ?>
                                                x
                                                <?= $pro->LabelHeight ?>
                                            </p>
                                            <p class="col-md-5"><strong>Item Code</strong><br>
                                                <?= $pro->ManufactureID ?>
                                            </p>
                                        </div>
                                        <a href="#" <?= $link ?> class="btn-block btn orange" role="button"><i
                                                    class="fa fa-arrow-circle-right"></i> Select </a></div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            <? } ?>
        </div>
        <?php if ($other != ''): ?>
            <div class="mat-ch">
                <h3 class="mat-ch-title">Other Integrated Labels</h3>
            </div>
            <div class="row">
                <? foreach ($other['list'] as $pro) {

                    $image = explode(".", $pro->CategoryImage);
                    $imagename = $image[0] . "_1.png";
                    if ($pro->Shape == 'Full Sheet Integrated') {
                        $size = $pro->LabelWidth . ' x ' . $pro->LabelHeight;
                        $product_a4 = $this->home_model->get_equivalent_id($size);
                        $link = "a4-sheets/rectangle/" . strtolower($product_a4->CategoryID) . "/?productid=" . $product_a4->ProductID;
                        $pro->ManufactureID = $product_a4->ManufactureID;
                    } else {
                        $link = 'onclick="getIntegratedDetail(' . "'" . strtolower($pro->CategoryID) . "'" . ')"';
                    }
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 ">
                        <div class="thumbnail">
                            <div class="imgBg text-center"><img id="int_<?= $pro->CategoryID ?>" alt="<?= $imagename ?>"
                                                                title="<?= $pro->CategoryImage; ?>"
                                                                src="<?= Assets . "images/categoryimages/Integrated/" . $pro->CategoryImage; ?>">
                                <div class="pull-left" style="position:absolute; left:5px; top:114px;"><a
                                            id="<?= $pro->CategoryID ?>" class="btn blueBg" href="javascript:void(0);"
                                            data-toggle="tooltip" title="Rotate Image"><i class="fa fa-retweet"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h2>
                                    <?= $pro->Shape ?>
                                    Labels </h2>
                                <p>
                                    <?= $pro->ProductName ?>
                                </p>
                                <div class="row">
                                    <p class="col-md-7"><strong>Label Size</strong><br>
                                        <?= $pro->LabelWidth ?>
                                        x
                                        <?= $pro->LabelHeight ?>
                                    </p>
                                    <p class="col-md-5"><strong>Item Code</strong><br>
                                        <?= $pro->ManufactureID ?>
                                    </p>
                                </div>
                                <a href="" <?= $link ?> class="btn-block btn orange" role="button"><i
                                            class="fa fa-arrow-circle-right"></i> Select </a></div>
                        </div>
                    </div>
                <? } ?>
            </div>
        <?php endif; ?>
        <?php if ($fullsheet_integrated != ''): ?>
            <div class="col-md-12">
                <div class="panel row">
                    <div class="col-md-12">
                        <div class="col-md-12 col-xs-12">
                            <h2 style="font-size: 20px;">Full Sheet Delivery, Pick &amp; Pack, Shipping Labels
                                <small>(A range of full A4 sheet labels with a removable section in the position
                                    indicated)
                                </small>
                            </h2>
                            <p>Although not technically an integrated label (label and paper combined), the listed full
                                sheet delivery labels below, provide the same functionality but with the added benefit
                                of being available in the complete range of material and adhesive options.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <? foreach ($fullsheet_integrated['list'] as $pro) {

                    $image = explode(".", $pro->CategoryImage);
                    $imagename = $image[0] . "_1.png";
                    if ($pro->Shape == 'Full Sheet Integrated') {
                        $size = $pro->LabelWidth . ' x ' . $pro->LabelHeight;
                        $product_a4 = $this->home_model->get_equivalent_id($size);
                        $link = "a4-sheets/rectangle/" . strtolower($product_a4->CategoryID) . "/?productid=" . $product_a4->ProductID;
                        $pro->ManufactureID = $product_a4->ManufactureID;
                    } else {
                        $link = 'onclick="getIntegratedDetail(' . "'" . strtolower($pro->CategoryID) . "'" . ')"';
                    }
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 ">
                        <div class="thumbnail">
                            <div class="imgBg text-center"><img id="int_<?= $pro->CategoryID ?>" alt="<?= $imagename ?>"
                                                                title="<?= $pro->CategoryImage; ?>"
                                                                src="<?= Assets . "images/categoryimages/Integrated/" . $pro->CategoryImage; ?>">
                                <div class="pull-left" style="position:absolute; left:5px; top:114px;"><a
                                            id="<?= $pro->CategoryID ?>" class="btn blueBg" href="javascript:void(0);"
                                            data-toggle="tooltip" title="Rotate Image"><i class="fa fa-retweet"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h2>
                                    <?= $pro->Shape ?>
                                    Labels </h2>
                                <p>
                                    <?= $pro->ProductName ?>
                                </p>
                                <div class="row">
                                    <p class="col-md-7"><strong>Label Size</strong><br>
                                        <?= $pro->LabelWidth ?>
                                        x
                                        <?= $pro->LabelHeight ?>
                                    </p>
                                    <p class="col-md-5"><strong>Item Code</strong><br>
                                        <?= $pro->ManufactureID ?>
                                    </p>
                                </div>
                                <a href="#" <?= $link ?> class="btn-block btn orange" role="button"><i
                                            class="fa fa-arrow-circle-right"></i> Select </a></div>
                        </div>
                    </div>
                <? } ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
<div class="whiteBg">
    <div class="container text-center">
        <? if (preg_match('/single-integrated-labels/i', $url)) { ?>
            <h2>SINGLE INTEGRATED LABELS</h2>
            <p>Single integrated labels are ideal if you want to streamline your fulfilment process by printing one
                sheet that contains picking and dispatch information, the customer invoice and a convenient peel-out
                address label. </p>
            <p> We stock a range of different single style integrated labels each offering a sheet with a peel-out label
                in varying sizes and positions. We offer layouts that are compatible with all the most popular
                marketplaces and platforms including Amazon, eBay, PayPal and many more. </p>
            <p> Choose from basic address labels, labels large enough to fit PPI information or international postage
                details, those suitable for one or multi-channel retailers or different size peel-out labels for
                barcodes or stock management purposes. Some designs even include perforations for easy removal of waste
                backing after the address label is used.
                Our integrated labels are manufactured to the highest standards, with address labels that stick reliably
                and sheets that print smoothly without causing paper jams. </p>
            <p> We offer a free sampling service and downloadable templates so you can identify the right single
                integrated labels for your business, but if you need any advice please contact us. </p>
        <? } else if (preg_match('/double-integrated-labels/i', $url)) { ?>
            <h2>DOUBLE INTEGRATED LABELS</h2>
            <p>With double integrated labels you get the benefit of being able to include a delivery address label and a
                return address label in each sheet. Including a self-adhesive return address for your customers
                increases their purchase satisfaction by making the returns process easy should it be necessary. A sheet
                with two integrated labels is also suitable for multiple dispatches where two delivery address labels
                are needed. </p>
            <p> We offer a range of different double style integrated labels all using high quality adhesive, paper
                face-stock and backing liners for performance you can rely on. Our market leading labels stick to all
                kinds of packaging and stay stuck to ensure safe, efficient delivery. They print smoothly and present a
                professional image for your business. Some of our twin integrated labels even come pre-perforated so you
                can tear off excess backing after address labels are removed. </p>
            <p> Choose the layout that best meets your business needs; we have designs that are suitable for all the
                main e-commerce platforms including Amazon, eBay and Magento. We offer options on label sizes so you are
                able to include PPI or postal information on larger labels, or use smaller ones for barcodes, basic
                return addresses or 'if undelivered please return to…' addresses. Take advantage of our free samples and
                downloadable templates to find your ideal layout or please contact us for advice. </p>
        <? } else if (preg_match('/triple-integrated-labels/i', $url)) { ?>
            <h2>TRIPLE INTEGRATED LABELS</h2>
            <p>Triple integrated labels provide even greater flexibility with three removable self-adhesive areas that
                you can use for address labels, returns labels, stock control and marketing purposes. </p>
            <p> Keeping all the relevant information printed on one easily usable sheet makes the picking, packing and
                dispatching of orders accurate and efficient. Our treble integrated labels offer superior performance
                that means smooth printing, long shelf life and labels that adhere and stay adhered on all kinds of
                packaging in all conditions. </p>
            <p> A sheet with three integrated labels assists in adding value for the customer by providing promotional
                codes or marketing messages. Something as simple as a label with your company web address could help put
                your company "front-of-mind" with the customer and because each sheet is printed for a specific order
                you can target special offers and promotions to appeal to individual customers.
                We provide a triple integrated label that is especially popular with e-sellers using Zen Cart. </p>
            <p> Download the templates or order a free sample to see which layout works best for your business, and if
                you need any help or advice then please contact us! </p>
        <? } else { ?>
            <div class="text-justify">
                <h2 class="text-center">INTEGRATED LABELS </h2>
                <p>For catalogue, e-commerce and e-retailers picking, packing and shipping, integrated labels are a
                    staple element to consider. If you already rely on integrated label forms, you'll know they save
                    order-processing time, improve order shipment accuracy and increase labour efficiency.</p>
                <p>A well designed form that shows your customer&acute;s order details along with all other important
                    information including how to return goods can improve your customer&acute;s experience with your
                    company. Adding a returns label to the document can also add trust and loyalty to your brand as the
                    whole shopping experience is simple and transparent.</p>
                <p><strong>Getting the best from your integrated labels</strong></p>
                <p>To ensure you get the best results when using your integrated labels, we have put together these top
                    tips to help you:</p>
                <ul>
                    <li> Don&acute;t stack the boxes more than five high</li>
                    <li>Always leave the boxes sealed to avoid dust settling</li>
                    <li> Store your labels at consistent temperature range between 20°C – 25°C</li>
                    <li>Don&acute;t keep your labels in direct sunlight, or in a damp or humid environment</li>
                    <li> Fan the sheets before placing into paper tray to reduce static and avoid paper jams</li>
                    <li> For the best results always place the labels in the paper tray with the paper only leading edge
                        e.g. label end at the back of the paper tray, facing the front. This may require you to make
                        firmware changes on your printer, but will improve the printer performance on long runs
                    </li>
                    <li>Always check the duty-cycle of your printer and follow the manufacturers recommendations for
                        batching and printed sheets per minute
                    </li>
                </ul>
            </div>
        <? } ?>
    </div>
</div>
<div class="printed-lba-call" style="border:none;">
    <div class="container ">
        <div class="col-md-8 col-sm-12">
            <h2>INFORMATION & ADVICE</h2>
            <p class="text-justify">If you need assistance or help deciding which integrated label format you require
                and whether to use a label/paper combination, or one of our full sheet label formats. Please contact our
                customer care team, via the live-chat facility on the page, our website contact form, telephone, or
                email and they will be happy to discuss your requirements for these delivery and shipping labels.</p>
        </div>
        <div class="col-md-4 col-sm-12 "><img class="img-responsive" src="<?= Assets ?>images/header/call_opr_1.png">
        </div>
    </div>
</div>
<script>

    /************* Label Finder **********/
    var contentbox = $('#ajax_material_sorting');

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $(document).on("change", "#integrate_filter", function (e) {
        var val = $(this).val();
        window.location.href = base + val;

    });
    $(document).on("click", ".pull-left > a", function (e) {
        var id = $(this).attr('id');
        var curent_class = $(this).attr('class');
        if (curent_class == 'btn blueBg') {
            var src = $("#int_" + id).attr('alt');
            $(this).removeClass('btn blueBg');
            $(this).addClass('btn orangeBg');
            $("#int_" + id).attr('src', base + 'theme/site/images/categoryimages/Integrated/' + src);
        } else {

            var src = $("#int_" + id).attr('title');
            $(this).removeClass('btn orangeBg');
            $(this).addClass('btn blueBg');
            $("#int_" + id).attr('src', base + 'theme/site/images/categoryimages/Integrated/' + src);
        }
    });


</script>
