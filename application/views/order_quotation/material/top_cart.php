<style>
.miniCartProduct span {
	font-size: 12px !important;
}
.miniCartProduct span:first-child {
	font-size: 14px !important;
	color: #00b6f0;
}
.miniCartProduct span:nth-child(2) {
	font-size: 13px !important;
}
.miniCartProduct td {
	vertical-align: top !important;
}
.miniCartProduct span.print_span {
	font-weight: 600;
	font-size: 13px !important;
}
#cart .btn {
	padding-right: inherit !important;
	border-radius: 4px;
}
#cart .miniCartProduct .btn i {
	margin: 0 !important;
	color: #fff !important;
}
</style>
<?   $controller = $this->router->fetch_class();
		if($controller =='wholesale')
		{
			$cart_detail = $this->shopping_model->show_quotation_basket();
		}
		else
		{
			$cart_detail = $this->shopping_model->show_cart();
		}						
	 ?>

<button class="btn pull-right" data-toggle="dropdown" type="button">
<div>
  <div class=" cBlue">
    <div> <i class="fa-3x  m0 fa fa-shopping-cart pull-left  "></i><span class=" m0 pull-left"> &nbsp;
      <?=count($cart_detail)?>
      </span>
      <div class="text-uppercase hidden-xs  hidden-sm pull-left cGray "> Products <br>
        in basket </div>
      <i class="fa fa-angle-down btn_s"></i></div>
  </div>
</div>
</button>
<ul class="dropdown-menu pull-right ">
  <? if(count($cart_detail) > 0){?>
  <li class="LblueH p-t-b-10"><span>
    <?=count($cart_detail)?>
    Items added <span class="pull-right"><i class="fa fa-cart-plus"></i></span></span> </li>
  <li style="height:243px; overflow-y:scroll;">
    <table class="table-striped" style="width:100%">
      <tbody>
        <?    $total = 0.00; $sub_inclvat = 0.00;
								  		foreach($cart_detail as $row) {
											     $prod = $this->shopping_model->show_product($row->ProductID);
												 $sub_inclvat = round($row->TotalPrice,2);
												if($controller !='wholesale')
												{
													if($row->Printing == "Y")
													{
														$sub_inclvat += $row->Print_Total;
													}
												}
												 $sub_inclvat = $this->home_model->currecy_converter($sub_inclvat, 'yes');
												 
											     $prod[0]['Image1'] = str_replace(".gif",".png",$prod[0]['Image1']);		
							                     $Product_Name=explode("-",$prod[0]['ProductName']);
												  
			                    				$x=explode("-",$prod[0]['ProductCategoryName']);  ?>
        <tr class="miniCartProduct">
          <td valign="top" style=""><div> <span>
              <?=$prod[0]['ManufactureID']?>
              </span> <span>
              <?=$Product_Name[0]?>
              - <small>
              <?=$Product_Name[1];?>
              </small> </span><span>
              <? if(isset($x[3]) and $x[3]!=''){ echo $x[3];}?>
              </span>
              <?php if($controller !='wholesale')
			  {
				  if($row->Printing == "Y")
				  {
					  $print_type = $row->Print_Type;
					  if($print_type == "Mono")
					  {
						  $print_type = "Monochrome - Black Only";
					  }
					  else if($print_type == "Fullcolour")
					  {
						  $print_type = "4 Colour Digital Process";
					  }
					  echo "<span class='print_span'>Printing: ".$print_type."</span>";
				  }
			  }
			  ?>
            </div></td>
          <td valign="top" style=""><? if($controller !='wholesale'){?>
            <span class="cBlue"> <?php echo symbol. number_format(($sub_inclvat), 2, '.', ''); ?> </span>
            <? } ?>
            <span><small> X
            <?=$row->Quantity?>
            </small></span> <a id="<?=$row->ID?>" href="javascript:void(0);" class="btn blueBg delete_item"> <i class="fa f-16 fa-trash"></i></a></td>
        </tr>
        <?  $total = $total+$sub_inclvat; } ?>
      </tbody>
    </table>
  </li>
  <? if($controller !='wholesale'){?>
  <li class="LblueH"><span>&nbsp;<span class="pull-right">
    <?=symbol.sprintf('%.2f', round($total,2));?>
    </span></span> </li>
  <li class="footerC">
    <ul class="  btn-block1">
      <li> <a rel="nofollow" href="<?=base_url()?>shoppingcart.php"  class=" col-md-6 bg " role="button"> View Cart <i class="fa fa-cart-plus"></i> </a> <a rel="nofollow" href="<?=SAURL?>transactionregistration.php" class="col-md-6 " role="button"> Checkout <i class="fa fa-arrow-circle-o-right"></i> </a> </li>
    </ul>
  </li>
  <? }else{?>
  <li class="footerC">
    <ul class="  btn-block1">
      <li> <a rel="nofollow" style=" width:90% !important;" href="<?=base_url()?>wholesale/view-quotation" class="col-md-12 " role="button"> Review Quotation <i class="fa fa-arrow-circle-o-right"></i> </a> </li>
    </ul>
  </li>
  <? } 
						  }else{?>
  <li class="LblueH p-t-b-10"><span>BASKET IS EMPTY<span class="pull-right"><i class="fa fa-cart-plus"></i></span></span> </li>
  <? } ?>
</ul>
