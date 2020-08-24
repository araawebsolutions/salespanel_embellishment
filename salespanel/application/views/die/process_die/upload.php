   
<div class="dataTables_wrapper">
           
    <div class="content with-actions">
        <? $path = custom_die_pdf.$data['file'];
			
        if(preg_match("/.pdf/is",$data['file'])){
            //$path = AJAXURL.'theme/site/images/pdf.png';
            $width_img = '';	
        }else if(preg_match("/.doc/is",$data['file']) || preg_match("/.docx/is",$data['file'])){
            //$path = AJAXURL.'theme/site/images/doc.png';
            $width_img = '';	
        }else{
            //$path = base_url().'theme/integrated_attach/'.$data['file'];
            $width_img = '50';	
                    }
        ?>
             
        <img src="<?=$path?>" width="70px" id="uploaded_image">
        <br><a href="<?=$path?>" target="_blank" id="lnkr"> <b style="color:blue;text-decoration:underline;font-size:12px">Large View</b></a>
        <br /> <br />
        <b>Upload New Die</b>
			  <br /> <br />
    	<form id="edit_pdf" enctype="multipart/form-data" action="<?php echo main_url;?>/dies/dies/edit_pdf">
            <div class="customfile">
                <input name="file" id="file" style="left: -198.05px; top: 10.7px; margin: 0px;" type="file">
            </div>
	   <input type="hidden" value="<?=$data['ID']?>" id="ID" name="ID">
            <button class="alert-button" style="color:#03F;text-shadow:none !important;" type="submit"><strong>Click to Update</strong></button>
        </form>
    </div>
</div>
            
            
            
            
            
            
  