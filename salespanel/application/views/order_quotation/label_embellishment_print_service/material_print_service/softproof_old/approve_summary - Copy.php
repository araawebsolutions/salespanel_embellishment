<style>
.artwork_titleX { font-size:15px; line-height:24px;  }
.green-i { color:#5cb85c; }
.red-i { color:#d9534f; }
.orange-i { color:#f0ad4e; }

.artwork_titleX h2 { font-size:15px; line-height:24px;  }
</style>

<link rel="stylesheet" href="<?=Assets?>css/printed-labels.css">


<div>
  <div class="container m-t-b-8 ">
    <div class="col-md-8">
      <ol class="breadcrumb  m0">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i></a></li>
        <li>Printing</li>
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
     <h2 class="BlueHeading"><strong>Artwork Approval Summary</strong></h2>
      <div class="artwork_titleX">
      
      <? $i=0;
	   foreach($result as $row){
		   $i++;
		 	if($row->status == 55){
					$status_class = 'fa fa-check-circle orange-i';
					$status_text = 'with named &quot;'.$row->name.'&quot; is pending for your approval.';
			}
			else if($row->status == 58){
					$status_class = 'fa-check-circle green-i';
					$status_text = 'with named &quot;'.$row->name.'&quot;  has approved for printing. ';
			}
			else if($row->status == 60){
					$status_class = 'fa fa-edit red-i';
					$status_text = 'with named &quot;'.$row->name.'&quot; Schedule for Amendments.  ';
			}
			 ?>
      	  <div  > <i class="fa <?=$status_class?>"></i> Artwork <?=sprintf("%02d", $i)?>  <?=$status_text?></div>
          <hr />
	  <? }?>
</div>
      
   
    </div>
    <div class="col-md-4 col-sm-12 ">
   	  <img onerror='imgError(this);' class="img-responsive" src="<?=Assets?>images/header/call_opr.png">
    </div>
    
    
          
  </div>
    
  </div>
</div>






<div class="container">
	<div class="row">
        <div class="col-sm-3">
            <div> 
                <div class="input-group stylish-input-group">
                    <input type="text" class="form-control"  placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>  
                    </span>
                </div>
            </div>
        </div>
	</div>
</div>
 
