<h4 class="m-l-10">Search by software:</h4>
<div class="m-t-10 image-t-15">
  <? foreach($compatible_list as $row){?>
  <div class="col-xs-6 col-md-2 ">
    <div style="height:50px;" class="">
        <a href="#" onclick="getIntegratedTypes('<?= str_replace(" ","-",strtolower($row->name))?>')">
            <img width="auto" height="auto" src="<?=Assets?>images/icons/<?=$row->image?>" alt="<?=$row->name?>"> </a> </div>
  </div>
  <? } ?>
  <div class="row row col-sm-10 col-xs-12">
      <a role="button"class="btn blueBg m-t-20" href="#" onclick="getIntegratedTypes('T406')">Single Integrated Labels</a>
      <a role="button" class="btn blueBg  m-t-20" href="#" onclick="getIntegratedTypes('T407')">Double Integrated Labels</a>
    <div class="clear hidden-lg hidden-md"></div>
    <a role="button"class="btn blueBg  m-t-20" href="#" onclick="getIntegratedTypes('T408')">Triple Integrated Labels</a>
      <a role="button"class="btn blueBg  m-t-20" href="#" onclick="getIntegratedTypes('T813')">Full Sheet Delivery Labels</a> </div>
</div>


<script>

    function getIntegratedTypes(val) {
        $('#material_tab').removeClass('disbaledd').addClass('activated')
        $.ajax({
            type: "post",
            url: mainUrl + "search/search/integrated",
            cache: false,
            data: {'catid':val},
            dataType:'html',
            success: function (data){
                var msg = $.parseJSON(data);
                var pageName = $('#mypageName').val();

                if(pageName != null && pageName !="" && pageName !='undefined'){

                    $('#ajax_material_sorting').hide();
                    $('#placeSearch').hide();
                    $('#order_detail_material').empty();

                    $('#order_detail_material').html(msg.html);
                    $('#compare_modal').modal('hide');
                }else{

                    $('#material_tab').removeClass('disbaledd');
                    $('#material_tab_link').attr('onclick','showmaterial()');
                    activeTab('material_tab_link');
                    showAndHideTabs('material_page');
                    $('#compare_modal').modal('hide');
                    $('#ajax_material_sorting').hide();

                    $('#material_page').html(msg.html);
                }


            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('Sorry For Wait');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }
</script>