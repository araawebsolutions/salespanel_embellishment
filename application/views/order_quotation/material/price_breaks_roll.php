<table class="table table-striped p-5">

  <tr class="info" height="28">

        <td align="center" style="background-color: #d9edf7;font-size: 13px;font-weight: bold;">NO. ROLLS</td>

        <td align="center" style="background-color: #d9edf7;font-size: 13px;font-weight: bold;">NO. LABELS</td>

        <td align="center" style="background-color: #d9edf7;font-size: 13px;font-weight: bold;">PRICE PER LABEL</td>

        <td align="center" style="background-color: #d9edf7;font-size: 13px;font-weight: bold;">TOTAL</td>

  </tr>

<?  





 $i=1; 

     foreach($breaks as $row){

						

						$latest_price = $this->home_model->calclateprice($mid, $row->Rolls, $LabelsPerSheet);

						$price = $latest_price['final_price'];

						$price = $this->home_model->currecy_converter($price, 'yes');

						$labels = $row->Rolls*$LabelsPerSheet;

                                                $perlabelprice = number_format($price/$labels,4,'.',''); 

					

						

					

			

			

			?>

              <tr>

                    <td align="center"><?=$row->Rolls?></td>

                    <td align="center"><?=$labels?></td>

                    <td align="center"><?=symbol.$perlabelprice?></td>

                    <td align="center"><?=symbol.$price?> <?=vatoption?> Vat</td>

              </tr>

          

  

  

  

  

  

  <? $i++; }?>

</table>

