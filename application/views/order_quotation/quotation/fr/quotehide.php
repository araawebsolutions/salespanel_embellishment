<?php
//error_reporting(1);
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);

?>
 <meta charset="UTF-8">

<style>



body{
font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
}
tr {
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
}
td {
font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
	font-size:11px;
     
}
tr.table_blue_bar {
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
tr.table_white_bar {
	background-color: #F0F0F0;
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
.invoicetable_PCode_loop {
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 10%px;
}
.invoicetable_description_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 80%;
}
.invoicetable_sml_headings_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 15%;
}
.invoicetable_Qty_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 10%;
}
.line_total_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 0 5px 5px;
	text-align: center;
	width: 70px;
}
.invoicetable_PCode {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 15%;
      color:#fff;
}
.invoicetable_description {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 50%;color:#fff;
}
.invoicetable_sml_headings {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 15%;color:#fff;
}
.invoicetable_Qty {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 10%;color:#fff;
}
.invoicetable_Qty22 {
	background-color:#17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	width: 4%;
}
.invoicetable_sml_headings2 {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 15%;
}
.invoicetable_Qty2 {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 10%;
}
.invuice_subtotal {
	border-bottom: 1px solid #cccccc;
	border: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 10px 5px 5px;
	text-align: left;
}
.invuice_subtotal_price {
	border-bottom: 1px solid #cccccc;
	border: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 0 5px 5px;
	text-align: left;
}


.invoicetable_bgBlue {
	background-color: #17b1e3;
	border-right: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
    color:#fff;
}

.invoicetable_tabel_border {
	border-bottom: 1px solid #cccccc;
	border-right: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
}


</style>


<table width="100%" align="center" border="0" cellspacing="0">
  <tr>
    <td><img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/theme/site/images/logo.png" border="0" width="160" height="66" /></td>
    <td width="30%" align="left" valign="middle"><?php
    	
			echo "<strong  style='margin-left:80px;'>QUOTATION :</strong> ";
			echo'<font color="#000000"> '.$OrderInfo['QuotationNumber'].'</font>';
		    ?>
        </td>
  </tr>
  
  </table>
  
  <br></br>
  
  
  
  
<table width="100%" align="center" border="0" cellspacing="0" >


  <tr>
    <td align="left" valign="top" class="print_address" width="50%">
    
    
    <!-- ------------------------------------->
   <table width="100%" border="0">
        <tr>
            <td align="left" class="print_address">AA Labels, </td>
        </tr>
         <tr>
            <td align="left" class="print_address">Nom commercial de Green Technologies Ltd. </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="print_address">23 Wainman Road, Peterborough, PE2 7BU</td>
        </tr>
    </table>
      
      <!-- ------------------------------------->
      
     </td>


    <td align="left" valign="top" width="50%">
    
    <table width="100%" border="0">
        <tr>
          <td align="left" class="print_address"><strong style="margin-left:80px;">Telephone: </strong></td>
          <td align="left" class="print_address"><span class="phone_right">+441733 588 390 (anglais uniquement)</span></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">e-mail: </strong></td>
          <td align="left" valign="top" class="print_address"><span class="phone_right"><a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#257cac;">customercare@aalabels.com</a></span></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">N° TVA: </strong></td>
          <td align="left" valign="top" class="print_address"><span class="phone_right">GB 945 028 620</span></td>
        </tr>
      </table>
      </td>
    
      
      </table>
      
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:10px;">
    <tr>
      
    <td  valign="top" style="padding-bottom:10px;width:50%">
      <table width="25%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" style="line-height:5px;height:20px"><h3 style="padding-top:100px; white-space:nowrap;color:#17b1e3;">
          Details de la commande</h3></td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-top:5px;"><table width="110%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="print_address"><b>QUOTATION nombre:</b></td>
                <td class="print_address"><?=$OrderInfo['QuotationNumber']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Date :</b></td>
                <td class="print_address"><?php echo date('jS F Y', $OrderInfo['QuotationDate']); ?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Heures:</b></td>
                <td class="print_address"><?php echo date('h:i:s A', $OrderInfo['QuotationTime']); ?></td>
              </tr>
               <tr>
                <td class="print_address"><b>Statut:</b></td>
                <td class="print_address"><?php 
                   $status= $this->user_model->getstatus($OrderInfo['QuotationStatus']);
                   echo $status[0]->StatusTitle;
           ?></td>
              </tr>
              
              
            </table>
          </td>
        </tr>
      </table>
      </td>
      
      


    <td align="" valign="top" style="padding-bottom:10px; width:50%">
      <table width="25%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="line-height:5px;height:20px"><h3 style="padding-top:100px; white-space:nowrap;color:#17b1e3;">Adresse d'expedition</h3></td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-top:5px;">
            <table width="180%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="print_address"><b>Compagnie:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryCompanyName']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Nom complet  :</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryFirstName'].' '.$OrderInfo['DeliveryLastName']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Email:</b></td>
                <td class="print_address"><?php echo date('h:i:s A', $OrderInfo['QuotationTime']); ?></td>
              </tr>
               <tr>
                <td class="print_address"><b>Ville:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryTownCity']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Royaume-Uni:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryCountyState']?></td>
              </tr>
               <tr>
                <td class="print_address"><b>Code postal:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryPostcode']?></td>
              </tr>
               <tr>
                <td class="print_address"><b>N° de phone:</b></td>
                <td class="print_address"><?=$OrderInfo['Deliverytelephone']?></td>
              </tr>
              
            </table>
          </td>
        </tr>
      </table>
      </td>
    
     
      
   
     
  </tr>
  
  
     </table> 
      

  
                   <!-- -------------------------------------------->

                    <?
                   $OrderInfo['currency']  = (isset($OrderInfo['currency']) && $OrderInfo['currency']!='')?$OrderInfo['currency']:'GBP';
				   $exchange_rate   = (isset($OrderInfo['exchange_rate']) && $OrderInfo['exchange_rate']!=0)?$OrderInfo['exchange_rate']:1;
				   $symbol = $this->user_model->get_currecy_symbol($OrderInfo['currency']);
				   
				   if($exchange_rate==0){ $exchange_rate = 1;}
				   ?>
 
 
 
 
 
 
    
    <table width="100%"  bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:0px;">
  <tr >
    <td class="invoicetable_bgBlue" width="15%">PRODUITS</td>
    <td class="invoicetable_bgBlue" width="55%">La description</td>
  </tr>
   
 
         <?php
       		 $total_exvat = 0;
             $total_invat = 0;
			 $i = 0;
			   $query = $this->db->get_where('quotationdetails', array('QuotationNumber' =>$OrderInfo['QuotationNumber']));
               $sumarrary = $query->result_array();
			   
		foreach ($OrderDetails as $AccountDetail) {
			
			if($i%2==0)
				{
					$css="class='table_blue_bar'";
				}
				else
				{
					$css="class='table_white_bar'";
				}
			
				 $LabelsPerSheet = 1;
				 $colorcode = (isset($AccountDetail->colorcode) and $AccountDetail->colorcode!='')?'-'.$AccountDetail->colorcode:'';
					 
					 	
				   if($AccountDetail->ProductID==0){
					$ManufactureID= $AccountDetail->ManufactureID;
				   }else{
					 $ManufactureID= $this->user_model->manufactureid("",$AccountDetail->ProductID);
				   }
				
				
				
				
			
		       	?>
   <tr>
    <td class="invoicetable_tabel_border"><?=$ManufactureID?></td>
    <td class="invoicetable_tabel_border"><?php 
	
	        if($AccountDetail->ProductID==0){
		          $prod_name = $this->user_model->ReplaceHtmlToString_($AccountDetail->ProductName);
		          if($ManufactureID!="SCO1"){
	              echo $prod_name;
		          }
		      }else{
	             $prod = $this->user_model->show_product($AccountDetail->ProductID);
				 $merge = array_merge($prod,$sumarrary[$i]);
		         $prod_name = $this->user_model->fetch_product_name($merge);
				 $prod_name = $this->user_model->ReplaceHtmlToString_($prod_name);
				   
                        echo $prod_name;
				  
			  }
			  ?>
			  
			   <? if($ManufactureID=="SCO1"){
        $custominfo = $this->user_model->fetch_custom_die_quote($AccountDetail->SerialNumber);
        $carRes = $this->user_model->getCartQuotationData($AccountDetail->SerialNumber);
       
        $mm = '';
        if($carRes[0]->height != null) {
            $mm=' x';
        }
													
        if($carRes[0]->shape!="Circle"){
            $carRes[0]->height = ($carRes[0]->height!=null)?($carRes[0]->height):($carRes[0]->width); 
            $mm=' x';
														
         } ?>
         
         
          <b>Forme: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?> |
            <b>Format:</b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?> |
            <b>Taille:  </b><?= (isset($carRes[0])) ? $carRes[0]->width.'mm'.$mm  : '' .' x' ?>
    <?= ((isset($carRes[0])) && $carRes[0]->height != null) ? (isset($carRes[0]) && $carRes[0]->width!="") ? $carRes[0]->width : '' : ($carRes[0]->height!="" && $carRes[0]->height!="NULL") ? $carRes[0]->height.'mm': '' ?> |
													 
            <b>N ° d'étiquettes / Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?> |
            <b>À travers: </b>       <?= (isset($carRes[0])) ? $carRes[0]->across : '' ?> |
            <b>Autour: </b>       <?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
													
            <?php if(($carRes[0]->shape != 'Circle') && ($carRes[0]->shape !='Oval')){?>
        | <b>Rayon de coin: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
        <?php } ?>
        | <b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>
         <?php //include(APPPATH . 'views/old_pdf_views/assc_die.php'); ?>
     <?php }?>
			  
			  
              
               <?   /*if($ManufactureID=="SCO1"){
					  $custominfo = $this->user_model->fetch_custom_die_quote($AccountDetail->SerialNumber);
					  include(APPPATH . 'views/old_pdf_views/fr/assc_die.php');
				   } */
			   ?>
               
          </td>
  </tr>
  
  
  
  
  
 <?   if($AccountDetail->Printing =="Y"){?> 
  <tr>
    <td class="invoicetable_tabel_border">Impression</td>
    <?php $print_style='font-size: 8px;'; include(APPPATH . 'views/old_pdf_views/fr/print_line_txt.php'); ?>
  </tr>
<? } ?>  
    
    
      <?php 
                                                                                       
        if($AccountDetail->qp_proof == 'Y'){ ?>
          <tr>
            <td class="invoicetable_tabel_border">
   
    <?php if ($AccountDetail->qp_foc == 'Y')     {     echo 'Preuve de presse - Foc';} ?>
    <?php if ($AccountDetail->qp_foc == 'other') {     echo $AccountDetail->qp_foc;} ?>
    <?php if ($AccountDetail->qp_foc != 'Y' && $AccountDetail->qp_foc != 'other') {
     echo 'Jusqu`à '.$AccountDetail->qp_qty.' Dessins '.$symbol.number_format($AccountDetail->qp_price * $exchange_rate,2,'.','');} ?>
          
  </td>
            
            <td>Preuve de presse physique, approbation préalable à la presse requise </td>
  </tr>
     <?php  } 
      ?>
    
      
			<? if($ManufactureID=="PRL1"){ 
               $result = $this->user_model->get_details_roll_quotation($AccountDetail->Prl_id);
             ?>
              <tr>
               <td class="invoicetable_tabel_border"></td> 
               <td class="invoicetable_tabel_border">   <b>Forme:</b>
						<?=$result['shape']?>
                        &nbsp;&nbsp; <b>Taille:</b>
                        <?=$result['size']?>
                        &nbsp;&nbsp; <b>Materiel:</b>
                        <?=$result['material']?>
                        &nbsp;&nbsp; <b>Impression:</b>
                        <?=$result['printing']?>
                        &nbsp;&nbsp; <b>Finition:</b>
               <?     if($result['finishing'] == "Gloss Lamination"){
						$finish_type_fr = 'Lamination Gloss';
					  }else if($result['finishing'] == "Matt Lamination"){
						$finish_type_fr = 'Matt Lamination';
					  }else if($result['finishing'] =="Matt Varnish"){
						$finish_type_fr = 'Vernis mat';
					  }else if($result['finishing'] == "Gloss Varnish"){
						$finish_type_fr = 'Vernis brillant';
					  }else{
						$finish_type_fr == 'No Finish';
					  } echo $finish_type_fr;
				   ?>
                        &nbsp;&nbsp; <b>pas de design:</b>
                        <?=$result['no_designs']?>
                        &nbsp;&nbsp; <b>N ° Rolls:</b>
                        <?=$result['no_rolls']?>
                        &nbsp;&nbsp; <b>N ° etiquettes:</b>
                        <?=$result['no_labels']?>
                        &nbsp;&nbsp; <b>Taille du noyau:</b>
                        <?=$result['coresize']?>
                        &nbsp;&nbsp; <b>Blessure:</b>
                        <?=$result['wound']?>
                        &nbsp;&nbsp;<b>Remarques:</b>
                        <?=$result['notes']?>
                        &nbsp;&nbsp;</td>
              </tr>
          <? } ?>
          
          
                 <? if($ManufactureID=="SCO1"){
					  include(APPPATH . 'views/old_pdf_views/fr/assc_material_hide.php');
				    }
			    ?>   
     
<? } ?>
 </tr>
</table>


