<style>

    #big_Table_wrapper .ui-toolbar {
        padding: 5px;
    }

    #big_Table_wrapper .ui-toolbar {
        padding: 5px;
    }

    .toolbar {
        display: inline-flex;
        float: left;
        margin-left: 18%;
        margin-top: 0rem;
        width: 18%;
    }

    .button {
        cursor: pointer;
        width: 100px;
    }

    .converter {
        color: red;
        font-weight: bold;
        text-decoration: underline;
        cursor: pointer;
    }

    #topnav {
        /* display: none;*/
    }

    label {
        margin-bottom: 0rem;
    }

    .select {
        background: #fff;
        border-radius: 5px;
        border-style: solid;
        border-width: 1px;
        box-sizing: border-box;
        display: block;
        height: 27px;
        outline: 0;
        padding: 0px 10px;
        width: 100%;
        font-weight: 400 !important;
        border-color: #bababa;
        color: #817d7d;
        font-size: 11.5px;
    }
</style>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card">

                    <div class="card-header card-heading-text">
                        <span><i class="fa fa-dot-circle-o"></i> Active Dies</span>
                        <span class="sea"></span>
                    </div>
                    <div class="card-body">
                        <div id="table-example_length">
                            <input type="hidden" id="chg" value="A4 Labels">
                            <input type="hidden" id="shp">

                            <?php echo $this->table->generate(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>


<div class="modal fade bs-example-modal-lg comment-modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background" id="comments_modal_data"></div>
    </div>
</div>
<script>

    $(document).ready(function () {
        var shape = $("#shaper option:selected").val();
        var labelCategory = $("#labelCategory option:selected").val();
        if (typeof shape === 'undefined') {
            shape = 'all';
        }
        if (typeof labelCategory === 'undefined') {
            labelCategory = 'all';
        }
        record(mainUrl + "dies/dies/diestable/" + shape + '/A4 Labels');
    });


    function record(order) {


        var progress = null;
        if (order == "undefined") {
            var shape = $("#shaper option:selected").val();
            var labelCategory = $("#labelCategory option:selected").val();
            var shape = $("#shaper option:selected").val();
            var labelCategory = $("#labelCategory option:selected").val();
            if (typeof shape === 'undefined') {
                shape = 'all';
            }
            if (typeof labelCategory === 'undefined') {
                labelCategory = 'all';
            }
            var order = mainUrl + "dies/dies/diestable/website/" + shape + '/' + labelCategory;
        }

        $('#aa_loader').show();

        var oTable = $('#datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "sAjaxSource": order,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'asc']],

            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            },

            "aoColumns": [

                {
                    "render": function (data, type, row) {
                        var str = row[0];
                        var code = str.substring(2);
                        return code;
                    }
                },
                {
                    "render": function (data, type, row) {

                        if (row[12] == 'SRA3 Label') {
                            var link = '<img src="<?=Assets?>images/categoryimages/SRA3Sheets/' + row[1] + '" height="100"/>';
                        }
                        else if (row[12] == 'A3 Label') {
                            var link = '<img src="<?=Assets?>images/categoryimages/A3Sheets/' + row[1] + '" height="100"/>';
                        }
                        else if (row[12] == 'Integrated Labels') {
                            var link = '<img src="<?=Assets?>images/categoryimages/Integrated/' + row[1] + '" height="100"/>';
                        }
                        else if (row[12] == 'A4 Labels') {
                            var link = '<img src="<?=Assets?>images/categoryimages/A4Sheets/' + row[1] + '" height="100"/>';
                        }

                        else if (row[12] == 'A5 Labels') {
                            var link = '<img src="<?=Assets?>images/categoryimages/A5Sheets/' + row[1] + '" height="100"/>';
                        }
                        return link;
                    }
                },
                {
                    "render": function (data, type, row) {
                        return row[2] + '<br><b>' + row[12] + '</b>';
                    }
                },
                null,
                null,
                {

                    "render": function (data, type, row) {
                        var dieType = '';
                        var condition = $('#labelCategory').val();
                        count = 1;
                        var die_type = row[5];
                        if (die_type == "Y") {
                            dieType = 'Euro';
                        }
                        else {
                            dieType = 'Standard';
                        }
                        if (condition == 'A4 Labels') {

                            return '<span>' + dieType + '</span><br/><a  class="converter" onclick="changeStatus(this)"  value="' + (die_type == 'Y' ? 'N' : 'Y') + '"  code="' + row[0].substring(2) + '" catId ="' + row[13] + '"  id="dieStatus' + row[0].substring(2) + '" ><b class="orange-text">Convert to ' + (die_type == "Y" ? 'Standard' : 'Euro') + '</b></a>';
                        } else {
                            return '<span>' + dieType + '</span>'
                        }
                    }, "sClass": "details",
                },
                null,
                null,
                null,
                null,
                {
                    "render": function (data, type, row) {
                        var display = row[10];
                        if (display == "both") {
                            return 'Yes';
                        } else {
                            return 'No';
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        return 'Yes';
                    }
                },
                {
                    "render": function (data, type, row) {
                         var isactive = row[14];
                          if (isactive == "N") {
                            isactive =  'In-Active';
                          } else {
                            isactive =  'Active';
                          }
                        
                        return '<a href="javascript:void(0)"><b data-vals="' + row[0].substring(2) + '" class="orange-text reorder_die">Reorder Die</b></a><br><b>'+isactive+'</b>';
                    }
                },
                {
                    "render": function (data, type, row) {
                        return '<a href="javascript:void(0)"><b data-code="' + row[0].substring(2) + '" class="orange-text timeLine">Timeline</b></a>';
                    }
                }
            ],

            'createdRow': function (row, data, dataIndex) {
                $(row).removeClass('odd');
                $(row).addClass('artwork-tr');
            },


            "fnInitComplete": function () {
                //  oTable.fnAdjustColumnSizing();
            },


            'fnServerData': function (sSource, aoData, fnCallback) {


                $('.dataTables_wrapper select, .dataTables_wrapper input').addClass("form-control form-control-sm");
                $('#aa_loader').show();

                $.ajax({
                    "dataType": 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
                $('#aa_loader').hide();

                var selectedids = sSource.replace("diestable/", "");

                var sha = $('#shp').val();
                var cats = $('#chg').val();

                var selectedshape = sha;
                var labelCategory = cats;

                var aller = a3 = a4 = a5 = int = sra3 = roll = '';

                if (labelCategory == "A3 Label") {
                    var a3 = "selected='selected'";
                } else if (labelCategory == "A4 Labels") {
                    var a4 = "selected='selected'";
                } else if (labelCategory == "A5 Labels") {
                    var a5 = "selected='selected'";
                } else if (labelCategory == "Integrated Labels") {
                    var int = "selected='selected'";
                } else if (labelCategory == "SRA3 Label") {
                    var sra3 = "selected='selected'";
                } else if (labelCategory == "Roll Labels") {
                    var roll = "selected='selected'";
                } else if (labelCategory == "all") {
                    var alls = "selected='selected'";
                }

                $('span.sea').html('<span class="pull-right"><button class="btn btn-primary waves-light waves-effect website_or_backoffice" style="    margin-right: 20px;" id="website" >All Dies</button><button class="btn btn-primary waves-light waves-effect website_or_backoffice" id="backoffice">Backoffice Only</button></span>');


                var aller = cir = rec = ov = st = he = ir = sq = '';
                if (selectedshape == "circular") {
                    var cir = "selected='selected'";
                } else if (selectedshape == "oval") {
                    var ov = "selected='selected'";
                } else if (selectedshape == "rectangle") {
                    var rec = "selected='selected'";
                } else if (selectedshape == "square") {
                    var sq = "selected='selected'";
                } else if (selectedshape == "star") {
                    var st = "selected='selected'";
                } else if (selectedshape == "heart") {
                    var he = "selected='selected'";
                } else if (selectedshape == "irregular") {
                    var ir = "selected='selected'";
                }

                $('span.sea').append('<select class="form-control" style="width:unset; display:inline;float:right; margin-right:20px; margin-left:20px;" id="shaper"><option value="all" ' + aller + '>Select Shape</option><option value="circular" ' + cir + '>Circular</option><option value="oval" ' + ov + '>Oval</option><option value="rectangle" ' + rec + '>Rectangular</option><option value="square" ' + sq + '>Square</option><option value="star" ' + st + '>Star</option><option value="heart" ' + he + '>Heart</option><option value="irregular" ' + ir + '>Irregular</option>');


                if (document.getElementById('labelCategory')) {
                    $('span.sea').html('<select id="labelCategory" class="form-control" style="display:inline; width:unset;  float:right;"><option value="all" ' + alls + '>ALL</option><option value="A3 Label" ' + a3 + '>A3 Labels</option><option value="A4 Labels" ' + a4 + '>A4 Labels</option><option value="A5 Labels" ' + a5 + '>A5 Labels</option><option value="Integrated Labels" ' + int + '>Integrated Labels</option><option value="SRA3 Label" ' + sra3 + '>SRA3 Labels</option><option value="Roll Labels" ' + roll + '>Roll Labels</option>');

                } else {
                    $('span.sea').append('<select id="labelCategory" class="form-control" style="display:inline; width:unset;  float:right;"><option value="all" ' + alls + '>ALL</option><option value="A3 Label" ' + a3 + '>A3 Labels</option><option value="A4 Labels" ' + a4 + '>A4 Labels</option><option value="A5 Labels" ' + a5 + '>A5 Labels</option><option value="Integrated Labels" ' + int + '>Integrated Labels</option><option value="SRA3 Label" ' + sra3 + '>SRA3 Labels</option><option value="Roll Labels" ' + roll + '>Roll Labels</option>');
                }
            }
        });
    }

    $(document).on("change", "#shaper", function (e) {
        var shape = $("#shaper option:selected").val();
        var labelCategory = $("#labelCategory option:selected").val();
        $('#shp').val($(this).val());
        record(mainUrl + "dies/dies/diestable/" + shape + '/' + labelCategory);
    });


    $(document).on("change", "#labelCategory", function (e) {

        var shape = $("#shaper option:selected").val();
        var labelCategory = $("#labelCategory option:selected").val();

        if (labelCategory == 'Roll Labels') {
            window.location.replace(mainUrl + "/dies/dies/rolldies");
        }

        $('#chg').val($(this).val());

        if (labelCategory != 'Roll Labels') {
            record(mainUrl + "dies/dies/diestable/" + shape + '/' + labelCategory);
        }
    });


    $(document).on("click", ".website_or_backoffice", function (e) {
        var webiste_or_backoffice = this.id;
        var shape = $("#shaper option:selected").val();
        var labelCategory = $("#labelCategory option:selected").val();
        record(mainUrl + "dies/dies/diestable/" + webiste_or_backoffice + '/' + shape + '/' + labelCategory);
    });


    $(document).on("click", ".reorder_die", function (e) {

        var codes = $(this).attr('data-vals');
        //alert(value);

        swal("Are you sure you want to create redorder for this die?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "Cancel",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":

                        $('#aa_loader').show();

                        $.ajax({
                            type: "POST",
                            url: mainUrl + "dies/dies/reorder_die",
                            cache: false,
                            data: {value: codes},
                            success: function (data) {
                                $('#aa_loader').hide();
                                swal("Success! Die added for reorder successfully!", {
                                    icon: "success",
                                    dangerMode: true,
                                });
                            }
                        });
                        break;
                }
            });
    });

    function changeStatus(event) {

        swal("Are you sure you want to Change this die?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "Cancel",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('#aa_loader').show();
                        var id = $(event).attr('id');
                        var dietype = $('#' + id).attr('value');
                        var categoryId = $('#' + id).attr('catId');
                        var code = $('#' + id).attr('code');

                        $.ajax({
                            type: "POST",
                            url: mainUrl + "dies/dies/changeMyDieStatus",
                            data: {status: dietype, categoryId: categoryId, code: code},
                            success: function (data) {

                                $('#aa_loader').hide();
                                var shape = $("#shaper option:selected").val();
                                record(mainUrl + "dies/dies/diestable/" + shape + '/A4 Labels');

                                swal("Success! Status Change successfully!", {
                                    icon: "success",
                                    dangerMode: true,
                                });

                            }
                        });
                        break;
                }
            });
    }


    $(document).on("click", ".timeLine", function (e) {
        var code = $(this).attr('data-code');

        $('#aa_loader').show();

        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/euro_standrad_timeline",
            cache: false,
            data: {code: code},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#comments_modal_data').html(data.html);
                $('.comment-modal').modal('show');
            },
            error: function () {
                $('#aa_loader').hide();
                swal("Warning!", 'Error while request..', 'warning');
            }
        });
    });
</script>



