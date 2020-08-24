<link rel="stylesheet" href="<?= Assets ?>css/printed-labels.css">
<style>
    .thumbnail h4 {
        text-transform: uppercase;
        font-size: 18px !important;
        color: #fd4913;
    }

    .printSt {
        min-height: 320px;
        margin-bottom: 15px;
    }

    .printSt i {
        background-color: #fd4913;
        border-radius: 100px;
        color: #fff;
        font-size: 50px;
        padding: 30px;
    }

    .printSt h2 {
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        padding: 10px;
        text-align: center;
        text-transform: uppercase;
        margin: 0px;
    }

    .printSt h2 small {
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .printSt p {
        color: #fff;
        font-size: 14px;
    }

    .btnLg {
        -moz-user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        font-size: 18px;
        font-weight: bold;
        line-height: 1.42857;
        margin-bottom: 0;
        padding: 12px 45px !important;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .titleX b {
        color: #17b1e3;
    }

    .printedBgHome h2 {
        background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
        border-radius: 8px;
        color: #fff;
        font-size: 26px;
        font-weight: bold;
        padding: 10px;
        text-align: center;
        text-transform: uppercase;
    }

    .printedBgHome h2 small {
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .printedBgHome p {
        color: #fff;
        font-size: 17px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .btnLgHome {
        border: 1px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        line-height: 1.42857;
        margin-bottom: 0;
        padding: 10px 14px !important;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        left: -10px;
        position: absolute;
        top: 140px;
        text-transform: uppercase;
    }

    .orderStep li {
        border-right: 0 solid rgba(0, 0, 0, 0.5);
        display: inline-block;
        float: left;
        height: auto;
        margin: 0;
        padding: 0;
        text-align: center !important;
        width: 20%;
    }

    .slidecarousel_height {
        height: 210px;
    }

    .slidecarousel_height #quote-carousel .carousel-indicators {
        bottom: 0;
        right: 50%;
        top: 180px;
    }

    .slidecarousel_height .carousel-indicators .active {
        background-color: #fd4913 !important;
    }

    .slidecarousel_height #quote-carousel .carousel-indicators li {
        border: 2px solid #fff;
    }

    .hide {
        display: none;
    }

</style>

<div>
    <div class="container m-t-b-8 ">
        <div class="col-md-8">
            <ol class="breadcrumb  m0">
                <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i></a></li>
                <li>Printing</li>
            </ol>
        </div>
    </div>
</div>


<div class="ourTeam">
    <div class="container">
        <div class="clear30"></div>

        <div id="headerbar"><? include('header.php'); ?></div>


        <form id="artwork_approval" method="post">


            <div class="thumbnail prMatDC">
                <div class="clear10"></div>
                <div class="col-md-12">
                    <div class="titleX"><b>Artwork Approval</b></div>
                    <p id="decline-section" style="display:none">You have selected a previously declined version, please
                        click proceed to continue.</p>
                    <p id="qa-section-header"> Before approving this artwork for printing, it is important that you
                        check the following: </p>
                    <div class="table-responsive" id="qa-section">

                        <table class="table table-striped labels-form " style="border:solid 2px #00aeef;">
                            <thead class="theadX">
                            <tr>
                                <th width="5%" align="left">Item</th>
                                <th width="40%" align="left">Check List</th>
                                <th width="12%" align="left">Approved</th>
                                <th width="14%" align="left">Amendment Req.</th>
                                <th width="34%" align="left">Description of Amendment</th>
                            </tr>
                            </thead>
                            <tbody>

                            <? $max = $this->home_model->fetch_maxversion($result['ID']);
                            if (empty($max)) {
                                $max['ref'] = 0;
                                $max['q1'] = $max['q2'] = $max['q3'] = $max['q4'] = $max['q5'] = $max['q6'] = $max['q7'] = 0;
                            }
                            $item = 0;
                            ?>

                            <? if ($max['q1'] == 0) {
                                $item++; ?>
                                <tr class="checklist" valign="middle">
                                    <td align="left"><?= $item ?></td>
                                    <td align="left">Is the spelling, grammar and positioning of text correct?</td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q1]" class="textOrange approve" value="1"
                                                   type="radio"/>
                                            <i></i></label></td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q1]" class="textOrange amend" value="0" type="radio"/>
                                            <i></i></label></td>
                                    <td align="left"><textarea name="feedback[q1_text]" rows="1"
                                                               class="form-control description"></textarea></td>
                                </tr>
                            <? } else { ?> <input name="feedback[q1]" class="textOrange approve hide" value="1"
                                                  type="radio" checked="checked"/> <? } ?>

                            <? if ($max['q2'] == 0) {
                                $item++; ?>
                                <tr class="checklist" valign="middle">
                                    <td align="left"><?= $item ?></td>
                                    <td align="left">Is the content information correct e.g. Asset codes, bar codes,
                                        contact details, dates, ingredients, prices etc?
                                    </td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q2]" class="textOrange approve" value="1"
                                                   type="radio"/>
                                            <i></i></label></td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q2]" class="textOrange amend" value="0" type="radio"/>
                                            <i></i></label></td>
                                    <td align="left"><textarea name="feedback[q2_text]" rows="1"
                                                               class="form-control description"></textarea></td>
                                </tr>
                            <? } else { ?> <input name="feedback[q2]" class="textOrange approve hide" value="1"
                                                  type="radio" checked="checked"/> <? } ?>

                            <? if ($max['q3'] == 0) {
                                $item++; ?>
                                <tr class="checklist" valign="middle">
                                    <td align="left"><?= $item ?></td>
                                    <td align="left">Are the text fonts correct e.g. Pitch and style?</td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q3]" class="textOrange approve" value="1"
                                                   type="radio"/>
                                            <i></i></label></td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q3]" class="textOrange amend" value="0" type="radio"/>
                                            <i></i></label></td>
                                    <td align="left"><textarea name="feedback[q3_text]" rows="1"
                                                               class="form-control description"></textarea></td>
                                </tr>
                            <? } else { ?> <input name="feedback[q3]" class="textOrange approve hide" value="1"
                                                  type="radio" checked="checked"/> <? } ?>

                            <? if ($max['q4'] == 0) {
                                $item++; ?>
                                <tr class="checklist" valign="middle">
                                    <td align="left"><?= $item ?></td>
                                    <td align="left">Is the alignment and ratio of the artwork correct e.g. As supplied
                                        and/or amended and agreed?
                                    </td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q4]" class="textOrange approve" value="1"
                                                   type="radio"/>
                                            <i></i></label></td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q4]" class="textOrange amend" value="0" type="radio"/>
                                            <i></i></label></td>
                                    <td align="left"><textarea name="feedback[q4_text]" rows="1"
                                                               class="form-control description"></textarea></td>
                                </tr>
                            <? } else { ?> <input name="feedback[q4]" class="textOrange approve hide" value="1"
                                                  type="radio" checked="checked"/> <? } ?>

                            <? if ($max['q5'] == 0) {
                                $item++; ?>
                                <tr class="checklist" valign="middle">
                                    <td align="left"><?= $item ?></td>
                                    <td align="left">Are the colours as agreed?</td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q5]" class="textOrange approve" value="1"
                                                   type="radio"/>
                                            <i></i></label></td>
                                    <td><label class="checkbox">
                                            <input name="feedback[q5]" class="textOrange amend" value="0" type="radio"/>
                                            <i></i></label></td>
                                    <td align="left"><textarea name="feedback[q5_text]" rows="1"
                                                               class="form-control description"></textarea></td>
                                </tr>
                            <? } else { ?> <input name="feedback[q5]" class="textOrange approve hide" value="1"
                                                  type="radio" checked="checked"/> <? } ?>

                            <? if (preg_match('/roll/is', $result['ProductName'])) { ?>

                                <? if ($max['q6'] == 0) {
                                    $item++; ?>
                                    <tr class="checklist" valign="middle">
                                        <td align="left"><?= $item ?></td>
                                        <td align="left">Have you checked and approved the roll winding?</td>
                                        <td><label class="checkbox">
                                                <input name="feedback[q6]" class="textOrange approve" value="1"
                                                       type="radio"/>
                                                <i></i></label></td>
                                        <td><label class="checkbox">
                                                <input name="feedback[q6]" class="textOrange amend" value="0"
                                                       type="radio"/>
                                                <i></i></label></td>
                                        <td align="left"><textarea name="feedback[q6_text]" rows="1"
                                                                   class="form-control description"></textarea></td>
                                    </tr>
                                <? } else { ?> <input name="feedback[q6]" class="textOrange approve hide" value="1"
                                                      type="radio" checked="checked"/> <? } ?>

                                <? if ($max['q7'] == 0) {
                                    $item++; ?>
                                    <tr class="checklist" valign="middle">
                                        <td align="left"><?= $item ?></td>
                                        <td align="left">Have you checked and approved the roll label core size?</td>
                                        <td><label class="checkbox">
                                                <input name="feedback[q7]" class="textOrange approve" value="1"
                                                       type="radio"/>
                                                <i></i></label></td>
                                        <td><label class="checkbox">
                                                <input name="feedback[q7]" class="textOrange amend" value="0"
                                                       type="radio"/>
                                                <i></i></label></td>
                                        <td align="left"><textarea name="feedback[q7_text]" rows="1"
                                                                   class="form-control description"></textarea></td>
                                    </tr>
                                <? } else { ?> <input name="feedback[q7]" class="textOrange approve hide" value="1"
                                                      type="radio" checked="checked"/> <? } ?>


                            <? } ?>

                            <input type="hidden" name="feedback[ref]" id="artworkvef" value="<?= $max['ref'] + 1 ?>"/>
                            <input type="hidden" name="feedback[approveref]" id="approveref"
                                   value="<?= $max['ref'] + 1 ?>"/>
                            <input type="hidden" name="language" id="language" value="<?= $language ?>"/>
                            </tbody>

                        </table>
                    </div>
                    <p class="text-justify" id="qa-section-footer">Once you have checked and approved your label design,
                        please use the button below to repeat the process for other designs and to proceed with the
                        production of your printed labels. If the design/s require amendment, use the commentary boxes
                        on the right of the form, adjacent to the tick boxes, to enter details of your requirements and
                        return to the customer care team for action using the button below.</p>
                    <input type="hidden" name="feedback[OrderNumber]" value="<?= $result['OrderNumber'] ?>"/>
                    <input type="hidden" id="artworkjobno" name="feedback[jobno]" value="<?= $result['ID'] ?>"/>
                    <input type="hidden" name="feedback[version]" id="artworkversion"
                           value="<?= $result['version'] ?>"/>


                    <div class="">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4"></div>
                            <div class="col-md-4  col-sm-4 col-xs-12 text-center">
                                <strong class="cBlue artworkno" id="artworkno"> 1 </strong> of <strong
                                        class="cBlue"> <?= $total ?>  </strong>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <button type="button" id="pleasewaitbutton" class="btn btn-block orange" disabled
                                        style="display:none">
                                    <img onerror='imgError(this);' id="world_loader_icon"
                                         src="<?= Assets ?>images/ring.gif" alt="AA Labels Loader"/> Please Wait.... <i
                                            class="fa fa-arrow-circle-right"></i>
                                </button>

                                <button type="button" class=" btn btn-block orange pull-right formsubmit"
                                        name="feedback[type]" value="approve" id="approver">
                                    Proceed <strong class="artworkno"> 1 </strong> of <strong
                                            class=""> <?= $total ?>  </strong></button>

                                <button class="btn btn-block orange formsubmit" type="button" name="feedback[type]"
                                        value="amend" style="display:none" id="amender"> Proceed <strong
                                            class="artworkno"> 1 </strong> of <strong class=""> <?= $total ?>  </strong>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    $(document).ready(function () {

        //var total_length = parseInt($('.approve').length);
        ///var amend = $('.amend:checked').length;
        ///var approve = $('.approve:checked').length;
        //var total = parseInt(approve)+parseInt(amend);

        $('.product_material_image').aaZoom();


        $('input:radio').change(function () {

            var total_length = parseInt($('.approve').length);
            var amend = $('.amend:checked').length;
            var approve = $('.approve:checked').length;
            var total = parseInt(approve) + parseInt(amend);
            if (total == total_length) {
                $('#amender').removeClass('orange');
                $('#amender').addClass('orangeBg');

                $('#approver').removeClass('orange');
                $('#approver').addClass('orangeBg');
            } else {
                $('#amender').removeClass('orangeBg');
                $('#amender').addClass('orange');

                $('#approver').removeClass('orangeBg');
                $('#approver').addClass('orange');
            }


            var amend = $('.amend:checked').length;
            if (amend > 0) {
                $('#amender').show();
                $('#approver').hide();
            } else {
                $('#approver').show();
                $('#amender').hide();
            }
        });
    });
    $(document).on("keypress keyup", ".description", function (e) {
        $(this).find('.description').css('border', '1px solid #cccccc');
        var val = $(this).val();
        if (val.length > 0) {
            $(this).parents('.checklist').find('.amend').prop('checked', true);
            $(this).parents('.checklist').find('.approve').prop('checked', false);
            $('#amender').show();
            $('#approver').hide();
        }
    });


    $(document).on("click", ".approve", function (e) {
        $(this).parents('.checklist').find('.description').val('');
    });

    $(document).on("click", ".ReviseSoftproofsList", function (e) {
        var maxref = $('#maxjobid').val();
        var source = $(this).find('.history_softproof').attr('src');
        var title = $(this).find('.history_softproof').attr('title');
        var ref = $(this).find('.history_softproof').attr('alt');


        $('#actual_softproof_title').html(title);
        $('#main_image_softproof').attr('src', source);
        if (maxref != ref) {
            switchoff();
            $('#approveref').val(ref);
        } else {
            switchon();
            $('#approveref').val(maxref);
        }

    });


    function switchon() {
        $('#decline-section').hide();
        $('#qa-section').show();
        $('#qa-section-header').show();
        $('#qa-section-footer').show();
        var amend = $('.amend:checked').length;
        if (amend > 0) {
            $('#amender').show();
            $('#approver').hide();
        } else {
            $('#approver').show();
            $('#amender').hide();
        }
    }

    function switchoff() {
        $('#qa-section').hide();
        $('#qa-section-header').hide();
        $('#qa-section-footer').hide();
        $('#decline-section').show();
        $('#approver').show();
        $('#amender').hide();
    }


    $(document).on("click", ".formsubmit", function (e) {

        var _this = this;

        var display = $('#decline-section').css('display');
        var total_length = parseInt($('.approve').length);

        var amend = $('.amend:checked').length;
        var approve = $('.approve:checked').length;
        var total = parseInt(approve) + parseInt(amend);
        var flag = '';
        $(".checklist").each(function (index) {

            var comments = $(this).find('.description').val();
            if ($(this).find('.amend').is(":checked") && comments.length == 0) {
                $(this).find('.description').css('border', '1px solid red');
                //$(this).find('.description').focus();
                flag = 'amendments';
            } else {
                $(this).find('.description').css('border', '1px solid #cccccc');
            }
        });

        if (flag == 'amendments') {
            swal('Please enter the amendments you required to continue.');
            return false;
        } else if ((total == total_length) || display == "block") {
            var type = $(this).val();
            var artworkrefval = $('#artworkvef').val();
            if (artworkrefval == 1) {
                var poptext = "Please confirm to continue";
            } else {
                var poptext = (display == "block") ? "You are approving a previously declined version of the soft-proof. Please click the confirm button to continue, or cancel to return to the artwork." : "Proceed with the revised file?";
            }

            swal({
                    title: poptext,
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn orangeBg",
                    confirmButtonText: "CONFIRM",
                    cancelButtonClass: "btn blueBg",
                    cancelButtonText: "CANCEL",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },

                function (isConfirm) {
                    if (isConfirm) {

                        var data = $('#artwork_approval').serializeArray();
                        data.push({name: 'feedback[type]', value: type});

                        $(_this).hide();
                        $('#pleasewaitbutton').show();

                        $.post("<?=base_url()?>ajax/artwork_approval", data, function (data) {
                            if (data.response == 'yes') {

                                $('#pleasewaitbutton').hide();
                                $(_this).show();

                                var artworkno = parseInt($('#artworkno').text());
                                artworkno = artworkno + 1;
                                $('.artworkno').html(artworkno);
                                switchon();
                                $('#headerbar').html(data.content);
                                $('#qa-section').html(data.qacontent);
                                $('#artwork_approval')[0].reset();
                                $('#approver').show();
                                $('#amender').hide();
                                $('#artworkjobno').val(data.artworkjobno);
                                $('#artworkversion').val(data.version);
                                $('#language').val(data.language);

                                $('#amender').removeClass('orangeBg');
                                $('#amender').addClass('orange');

                                $('#approver').removeClass('orangeBg');
                                $('#approver').addClass('orange');
                                $('.product_material_image').aaZoom();

                            } else if (data.response == 'completed') {
                                var url = window.location.href;
                                window.location.href = url + '?action=approved';
                            }

                        }, 'json');

                    } else {

                    }
                });

        } else {
            swal('Please complete the checklist to continue.');
        }

    });


</script>
