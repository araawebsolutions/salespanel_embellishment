<div class="clear5"></div>
<div class="col-md-7 col-xs-12 col-sm-7 text-justify">
  <div class="title"> <b>Design Service</b> </div>
  <div class="clear10"></div>
  <p class="text-justify" >If you do not have press-ready artwork prepared for upload our studio design service is available. If you would like AA Labels to assist with the creation of your label designs, please indicate how many you require and the price will be added to your order.</p>
  <p> You will also need to upload any files e.g. brand/logo's, colour samples and text, that you require in your designed artwork, along with additional instructions in the box below, or send these to us via email at <a href="#">customercare@aalabels.com</a> and a member of our team will be in contact to discuss and take your design brief. </p>
</div>
<div class="col-xs-12 col-sm-5 col-md-5 text-center"> <img onerror='imgError(this);' class="img-responsive lSumR_img" src="<?=Assets?>images/categoryimages/labelShapes/theme-img.png" alt="AA Labels Artwork Design Service"> </div>
<div class="col-md-12" >
  <div class="clear15"></div>
  <table class="table table-striped labels-form">
    <thead>
      <tr>
        <th width="55%" align="left">No. of Design </th>
        <th width="30%" align="left">Price </th>
        <th width="20%" align="center">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td width="55%" align="left">1 Design</td>
        <td width="30%" align="left"><?=symbol.$this->home_model->currecy_converter(50, 'yes').' '.vatoption?>
          VAT</td>
        <td width="20%" align="center"><label class="radio">
            <input name="print_designservice" data-val="50" class="textOrange designservicecharge" value="1" type="radio" />
            <i></i></label></td>
      </tr>
      <tr>
        <td width="55%" align="left">2 Designs</td>
        <td width="30%" align="left"><?=symbol.$this->home_model->currecy_converter(75, 'yes').' '.vatoption?>
          VAT</td>
        <td width="20%" align="center"><label class="radio">
            <input name="print_designservice" data-val="75" class="textOrange designservicecharge" value="2" type="radio" />
            <i></i></label></td>
      </tr>
      <tr>
        <td width="55%" align="left">3 Designs</td>
        <td width="30%" align="left"><?=symbol.$this->home_model->currecy_converter(95, 'yes').' '.vatoption?>
          VAT</td>
        <td width="20%" align="center"><label class="radio">
            <input name="print_designservice" data-val="95" class="textOrange designservicecharge" value="3" type="radio" />
            <i></i></label></td>
      </tr>
      <tr>
        <td width="55%" align="left">4 Designs</td>
        <td width="30%" align="left"><?=symbol.$this->home_model->currecy_converter(110, 'yes').' '.vatoption?>
          VAT</td>
        <td width="20%" align="center"><label class="radio">
            <input name="print_designservice" data-val="110" class="textOrange designservicecharge" value="4" type="radio" />
            <i></i></label></td>
      </tr>
      <tr>
        <td width="55%" align="left">5 Designs</td>
        <td width="30%" align="left"><?=symbol.$this->home_model->currecy_converter(120, 'yes').' '.vatoption?>
          VAT</td>
        <td width="20%" align="center"><label class="radio">
            <input name="print_designservice" data-val="120" class="textOrange designservicecharge" value="5" type="radio" />
            <i></i></label></td>
      </tr>
      <tr>
        <td width="55%" align="left">Subsequent Additional Designs (Per Design) </td>
        <td width="30%" align="left"><?=symbol.$this->home_model->currecy_converter(10, 'yes').' '.vatoption?>
          VAT</td>
        <td width="20%" align="center"><!--<label class="radio">
        	 	 	<input name="print_designservice" data-val="10" class="textOrange designservicecharge" value="plain" type="radio" /><i></i>
                 </label>--></td>
      </tr>
    </tbody>
  </table>
  <div class="clear15"></div>
  <div class="col-md-12">
    <p> Please add your comments here and attach any relevant files ex. logo colour etc </p>
    <textarea class="form-control" rows="3" id="comments" placeholder="Comments"></textarea>
    <div class="clear10"></div>
    <div>
      <input type="file" id="desingservice_artwork_file" class="artwork_file"  style="display:none;"  />
      <button class=" btn blueBg desingservice_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button>
    </div>
    <div class="clear10"></div>
    <p class="text-justify">Thank you for using our design services, our customer care team will contact you to discuss your requirements.</p>
  </div>
</div>
