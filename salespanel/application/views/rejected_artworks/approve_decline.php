
<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header no-bg">

                        <div class="carousel-container" >
                            <div id="slider-carousel" class="owl-carousel" >








                            </div>
                            <div class="customNavigation" >
                                <a class="btn gray " onclick="pre()" ><i class="mdi mdi-menu-left"></i></a>
                                <input type="hidden" id="prev">
                                <input type="hidden" id="prev_index">
                                <div class="approve-decline-buttons">
                                   <div id="apr_rej_status">
                                    <div>
                                        <button type="button" onclick="declineCondition()"
                                                class="btns btn-outline-dark waves-light waves-effect btn-countinue m-r-10"
                                                data-toggle="modal" data-target="#exampleModal">
                                            Decline
                                        </button>

                                        </br>
                                        <span class="approve-decline-buttons-text" id="ord_no"></span>
                                    </div>
                                    <div>

                                        <button type="button" onclick="approveCondition()" class="btns btn-outline-dark waves-light waves-effect btn-countinue btn-print1" data-toggle="modal" data-target="#exampleModal1">Approve</button>
                                        </br>
                                        <span id="prinjob"></span>
                                    </div>
                                    </div>
                                </div>
                                <a class="btn gray " onclick="next()"><i class=" mdi mdi-menu-right"></i></a>
                                <input type="hidden" id="next">
                                <input type="hidden" id="next_index">
                            </div>

                            <!-- en row -->


                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Approve Checklist -->
        <div class="modal fade bs-example-modal-lg"  tabindex="-1"
             role="dialog" aria-labelledby="myLargeModalLabel"   id="approve_check_list" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content blue-background">
                    <div class="modal-header checklist-header">
                        <div class="col-md-12">
                            <h4 class="modal-title checklist-title" id="myLargeModalLabel">I have checked</h4>
                        </div>
                    </div>
                    <div class="modal-body p-t-0">
                        <div class="panel-body">


                            <table class="table table-bordered taable-bordered f-14">
                                <thead>
                                <tr>
                                    <th class="text-center">Sr.</th>
                                    <th>Questions</th>
                                    <th colspan="2" class="text-center">Options</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Font / Style</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="font"  type="checkbox" value="1">
                                            <label for="font" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Copy / Content</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="Copy_content" type="checkbox" value="1">
                                            <label for="Copy_content" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Colours</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="Colours" type="checkbox" value="1">
                                            <label for="Colours" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Label Size</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="label_size" type="checkbox" value="1">
                                            <label for="label_size" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Template ID</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="templateid" type="checkbox" value="1">
                                            <label for="templateid" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Material</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="material" type="checkbox" value="1">
                                            <label for="material" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td>Design Name</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="designname" type="checkbox" value="1">
                                            <label for="designname" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">8</td>
                                    <td>Bleed</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="bleed" type="checkbox" value="1">
                                            <label for="bleed" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">9</td>
                                    <td>Safe Marigin</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="safe_margin" type="checkbox" value="1">
                                            <label for="safe_margin" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">10</td>
                                    <td>Orientation</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="orientation" type="checkbox" value="1">
                                            <label for="orientation" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">11</td>
                                    <td>White if Applicable</td>
                                    <td colspan="2">
                                        <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
                                            <input id="whitifaplicable" type="checkbox" value="1">
                                            <label for="whitifaplicable" class="p-m-0">
                                                YES
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>


                            <span class="m-t-t-10 pull-right"><button type="button" onclick="approve()" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Submit</button></span>
                            <span class="m-t-t-10 pull-right"><button type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button></span>


                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Approve Checklist End -->
        <!-- Artwork Decline Popup Start -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"   id="decline_check_list" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content blue-background">
                    <div class="modal-header checklist-header">
                        <div class="col-md-12">
                            <h4 class="modal-title checklist-title" id="myLargeModalLabel">Please add your comments</h4>
                        </div>
                    </div>
                    <div class="modal-body p-t-0">
                        <div class="panel-body">
                            <div class="col-12 no-padding">
                                <textarea id="decline_comment" class="form-control blue-text-field" rows="5"></textarea>
                            </div>


                            <span class="m-t-t-10 pull-right"><button onclick="decline()" type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Submit </button></span>
                            <span class="m-t-t-10 pull-right"><button type="button"
                                                                      class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button></span>


                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Artwork Decline End -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
        <script type="text/javascript">
            var sortedArray = "";
            $(document).ready(function () {
                    getSlider();
            });

            function next() {
                var orderNo = $('#odno').val();
                var next = parseInt($('#next_index').val(),10);

                if(next < sortedArray.length){
                    getImage(next,orderNo);
                    $('#next_index').val((next+ 1));
                    var pre = parseInt($('#prev_index').val(),10);
                    $('#prev_index').val((pre+ 1));
                    owl.trigger('owl.next');
                }else{
                    getImage(0,orderNo);
                    $('#next_index').val(1);
                    $('#prev_index').val(0);
                }
            }

            function pre() {
                var orderNo = $('#odno').val();
                var pre = parseInt($('#prev_index').val(),10);

                if(pre >0){
                    getImage(pre,orderNo);
                    $('#prev_index').val((pre - 1));
                    var next = parseInt($('#next_index').val(),10);
                    $('#next_index').val((next- 1));
                    owl.trigger('owl.prev');
                }else{
                    getImage(0,orderNo);
                    $('#next_index').val(1);
                    $('#prev_index').val(0);
                }
            }

            function getImage(id,orderNumber) {
                var orderIntegratedId = sortedArray[id];
                $.ajax({
                    type: "get",
                    url: mainUrl+'Artworks/getImage',
                    cache: false,
                    data:{'id':orderIntegratedId,orderNumber:orderNumber },
                    dataType: 'json',
                    success: function(data)
                    {
                        inicarsol();

                        $('#prinjob').html('Print Job No: <b>PJ'+data.orderIntegratedId+' </b>');
                        $('#slider-carousel').html(data.html);

                        if(data.approve_reject_status === 'true'){
                            $('#apr_rej_status').show();
                        }else{
                            $('#apr_rej_status').hide();
                        }
                    },
                    error: function(){
                        alert('Error while request..');
                    }
                });
            }

            function getSlider() {

                $.ajax({
                    type: "get",
                    url: mainUrl+'Artworks/getOrderSliderImage',
                    cache: false,
                    data:{'orderNumber':'<?=$orderNumber?>',orderIntegratedId:<?=$orderIntegratedId?> },
                    dataType: 'json',
                    success: function(data)
                    {
                        $('#next').val(data.sortedArray[1]);

                        $('#next_index').val(1);

                        $('#prev').val(data.sortedArray[0]);

                        $('#prev_index').val(0);

                        $('#ord_no').html('Order No: <b>'+data.orderNumber+'</b>');
                        $('#prinjob').html('Print Job No: <b>PJ'+data.orderIntegratedId+' </b>');

                        sortedArray = "";
                        sortedArray = data.sortedArray;

                        $('#slider-carousel').html(data.html);

                        if(data.approve_reject_status === 'true'){
                            $('#apr_rej_status').show();
                        }else{
                            $('#apr_rej_status').hide();
                        }
                        inicarsol();

                    },
                    error: function(){
                        alert('Error while request..');
                    }
                });


            }

            function inicarsol() {
                var owl = $("#slider-carousel");
                owl.owlCarousel({
                    items: 3,
                    itemsDesktop: [1000, 3],
                    itemsDesktopSmall: [900, 2],
                    itemsTablet: [600, 1],
                    itemsMobile: false,
                    pagination: false,
                    mouseDrag: false,
                    scrollPerPage: true,
                    slideSpeed: 1000,
                    loop: true

                });
            }

            function approveCondition() {
                $('#approve_check_list').modal('show');
            }

            function declineCondition() {
                $('#decline_check_list').modal('show');
            }

            function approve() {

                if(allCheckAreClear()){
                    var font = $("#font").val();
                    var Copy_content = $("#Copy_content").val();
                    var Colours = $("#Colours").val();
                    var label_size = $("#label_size").val();
                    var templateid = $("#templateid").val();
                    var material = $("#material").val();
                    var designname = $("#designname").val();
                    var bleed = $("#bleed").val();
                    var safe_margin = $("#safe_margin").val();
                    var orientation = $("#orientation").val();
                    var whitifaplicable = $("#whitifaplicable").val();


                    var pre = parseInt($('#prev_index').val(),10);
                    var orderIntegratedId = sortedArray[pre];
                    $.ajax({
                        type: "get",
                        url: mainUrl+'Artworks/approveJob',
                        cache: false,
                        data:{Colours:Colours,safe_margin:safe_margin,orientation:orientation,whitifaplicable:whitifaplicable,orderIntegratedId:orderIntegratedId ,font:font,Copy_content:Copy_content,label_size:label_size,templateid:templateid,material:material,designname:designname,bleed:bleed},
                        dataType: 'json',
                        success: function(data)
                        {
                            $('#apr_rej_status').hide();
                            $('#approve_check_list').modal('hide');
                        },
                        error: function(){
                            alert('Error while request..');
                        }
                    });
                }

            }

            function decline() {
                if($('#decline_comment').val() !=null){
                    var pre = parseInt($('#prev_index').val(),10);
                    var orderIntegratedId = sortedArray[pre];
                    $.ajax({
                        type: "get",
                        url: mainUrl+'Artworks/declineJob',
                        cache: false,
                        data:{orderIntegratedId:orderIntegratedId,comment:$('#decline_comment').val()},
                        dataType: 'json',
                        success: function(data)
                        {
                            $('#apr_rej_status').hide();
                            $('#decline_check_list').modal('hide');
                        },
                        error: function(){
                            alert('Error while request..');
                        }
                    });
                }

            }

            function allCheckAreClear() {

                if($("#font").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#Copy_content").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#Colours").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#label_size").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#templateid").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#material").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#designname").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#bleed").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#safe_margin").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#orientation").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }if($("#whitifaplicable").prop('checked') == false){
                    alert('please Check All Conditions ..');
                    return false;
                }

                return true;
            }
        </script>