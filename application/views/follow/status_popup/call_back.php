<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<!--<script src="<?/*= URL*/?>theme/assets/js/timepick.js">

</script>-->

<!--<script src="<?/*= URL*/?>theme/assets/js/acda.js">

</script>-->
<div class="panel-body">
    <p class="message-field-title"><?=$title?></p>
    <div class="col-12 no-padding">

        <input  placeholder="0000-00-00" autocomplete="off"  name="date"   data-toggle="datepicker" id="date" class="form_datetime form-control blue-text-field" type="text" >
        <br>
        <div class="input-group bootstrap-timepicker timepicker no-padding " >

            <input id="time" type="text" class="timepicker1 form-control blue-text-field" name="time">

        </div>


        <!--<input placeholder="0000-00-00 00:00" name="date" class="calendar form-control blue-text-field" id="date" type="datetime-local" />
 -->
    </div>
    <span class="m-t-t-10 pull-right">
        <button type="button" onclick="changeStatus(<?=$status?>,'<?=$refno?>')" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Confirm</button>
    </span>
    <span class="m-t-t-10 pull-right">
        <button type="button" onclick="hidestatusModal()" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button>
    </span>
</div>
<script type="text/javascript">
    $('.timepicker1').timepicker(
        {
            zIndex: 2000
        }
    );


</script>

<script type="text/javascript">
  /* $("form_datetime").datetimepicker({
       format: 'yyyy-mm-dd',
       zIndex: 2000

   });*/

   $(function () {
       $('[data-toggle="datepicker"]').datepicker({
           autoHide: true,
           zIndex: 2000,
           format: 'yyyy-mm-dd'
       });
   });

</script>
<!--/<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
//<script src="<?/*= ASSETS */?>assets/js/bootstrap-datetimepicker.js"></script>-->
<!--<script>
    $("#calendarsss").datetimepicker({
        minDate:0
    },  //dateFormat:	'yy-mm-dd',
        // timeFormat: 'H:mm ',
        //        format: 'yy-mm-dd',
        //       formatTime: 'H:i',
        //        formatDate: 'yy-mm-dd',
        //        timepicker: true,
        //        datepicker: true,
        //      zIndex: 2000,
        //       addSliderAccess: true,
        //       sliderAccessArgs: {touchonly: false},        onClose: function(selectedDate,selectedTime) {            $("#calendar").datetimepicker("option", "minDate", selectedDate,selectedTime);        }    });
</script>-->