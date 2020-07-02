<style>
.artwork_titleX {
  font-size: 14px;
  line-height: 20px;
}
.ourTeam h2 {
     color: #17b1e3 !important; 
    margin: 0 0 30px;
}
.green-i { color:#5cb85c; }
.red-i { color:#d9534f; }
.orange-i { color:#f0ad4e; }

.artwork_titleX h2 { font-size:15px; line-height:24px;  }
.pending{ background-color:#f0ad4e; }
</style>

<link rel="stylesheet" href="<?=Assets?>css/printed-labels.css">


<div>
  <div class="container m-t-b-8 ">
    <div class="col-md-8">
      <ol class="breadcrumb  m0">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i></a></li>
        <li>Récapitulatif d'approbation de l'illustration</li>
      </ol>
    </div>
  </div>
</div>


<div class="ourTeam">
  <div class="container">
    <div class="clear30"></div>
    
  
	
    
   <div class=" thumbnail ">
    <div class="col-md-8 col-sm-12 ">
    <div class="clear15"></div>
     <h2 class="BlueHeading"><strong>Récapitulatif d'approbation de l'illustration</strong></h2>
      <div class="artwork_titleX">
      
      <p>Merci d'avoir répondu à notre demande d'approbation de l'oeuvre soft-proof / s pour votre commande. Si vous avez approuvé la / les conception (s), votre commande passera automatiquement à la presse pour la production de vos étiquettes imprimées.</p>
      
      <p>Si vous avez demandé un amendement à l'œuvre d'art, ceci a été retourné à notre équipe de conception de studio pour le remaniement et à la fin vous serez notifié encore pour approuver les changements faits.</p>
      
      <p>S'il vous plaît noter que si vous avez d'autres conceptions avec cette commande qui n'ont pas été approuvés, ou pour lesquels des modifications sont en cours, la commande ne se poursuivra pas jusqu'à ce que ceux-ci ont également été approuvés.</p>
    
    
 </div>
      
   
    </div>
    <div class="col-md-4 col-sm-12 ">
   	  <img onerror='imgError(this);' class="img-responsive m-t-15" src="<?=Assets?>images/header/man_doing.png">
    </div>
    
 <div class="col-md-12 col-sm-12">
       
      <table class="table table-striped p-5" style=" border:1px solid #17b1e3;">
          <tbody>
              <tr class="info" height="28">
                    <td style="text-align:left; border:1px solid #17b1e3;" align="center">COMMANDEZ NON.</td>
                    <td style=" border:1px solid #17b1e3;" valign="middle" align="center"><?=$result[0]->OrderNumber?></td>
                    <td style=" border:1px solid #17b1e3;" colspan="5" align="center">SOMMAIRE DE L'APPROBATION DE L'OEUVRE</td>
              </tr>
          <tr class="warning">
                <td style="text-align:center;border-right:1px solid #17b1e3;">Design No.</td>
                <td style=" border-right:1px solid #17b1e3;" align="center">Votre référence.</td>
                <td style=" border-right:1px solid #17b1e3;" align="center">Print Job No.</td>
                <td style=" border-right:1px solid #17b1e3;" align="center">NON. Étiquettes</td>
                <td style=" border-right:1px solid #17b1e3;" align="center">NON. Rouleaux / feuilles</td>
                <td style=" border-right:1px solid #17b1e3;" align="center">Version</td>
                <td align="center">Statut</td>
          </tr>
      
      <? $i=0;
	   foreach($result as $row){
		   $approve_ref = $this->home_model->fetch_approve_ref($row->ID);
		   $i++;
		 	 if($row->status == 64){
			  $status_class = 'pending';
			  $status_text = ' PENDING APPROVAL ';
			}else if($row->status == 65 && $row->version > 1){
		       $status_class = 'danger';
			   $status_text = 'MODIFICATION NÉCESSAIRE.';
		    }else if($row->status == 65){
					$status_class = 'pending';
					$status_text = 'ATTENDRE SOFTPROOF ';
			}else if($row->status == 68){
					$status_class = 'success';
					$status_text = 'AVERTISSEMENT IMPRIMER LE FICHIER';
			}else if($row->status == 70){
					$status_class = 'success';
					$status_text = 'APPROUVÉ POUR IMPRIMER ';
			}
			 ?>
             
        <tr>
            <td style="text-align:center;border-right:1px solid #17b1e3;"><?=sprintf("%02d", $i)?></td>
            <td style=" border-right:1px solid #17b1e3;" align="center"><?=$row->name?></td>
            <td style=" border-right:1px solid #17b1e3;" align="center"><?='PJ'.$row->ID?></td>
            <td style=" border-right:1px solid #17b1e3;" align="center"><?=$row->labels2?></td>
            <td style=" border-right:1px solid #17b1e3;" align="center"><?=$row->qty?></td>
            <td style=" border-right:1px solid #17b1e3;" align="center">V<?=$approve_ref?></td>
            <td class="<?=$status_class?>" style="text-align:left; background-color:"><?=$status_text?></td>
       </tr>
          
      	  
	  <? }?>
      
        </tbody>
  </table>
  
</div>
    
    
          
  </div>
    
  </div>
</div>







 
