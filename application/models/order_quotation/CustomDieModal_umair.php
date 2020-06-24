<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CustomDieModal extends CI_Model
{
    public function calculatePrice(){

        $this->updateClick();
        $condition = $this->input->post('condition');
        $diecode = $this->getNearestMatch($this->input->post('widths'),$this->input->post('heights'),$_REQUEST['formats'],$_REQUEST['shapes'],$condition);
        
        //print_r($diecode);die();
        
        if($diecode !=null && !isset($diecode['message']) && !isset($diecode['message1'])){

            $width = $this->getWidth();
          
            if(isset($width['message'])){
                return $width;
            }else{
                if($width !=0){
                    $records = $this->getPrice($_REQUEST['labelss'],$width);

                    $keys = array_keys($records[0]);
                
                    $key = $this->getKey($keys,$width); //91
                   
                    $actualPrice = ($records[0][$key] !=null)?$records[0][$key]:0;
                  
                    if($actualPrice !=0){

                        $afterPercentage = ($_REQUEST['formats'] == 'Roll')?($actualPrice / .70):(($actualPrice + 20) / .70);
                        $price = ($_REQUEST['formats'] == 'SRA3' || $_REQUEST['formats'] == 'A3')?($afterPercentage + $afterPercentage):$afterPercentage;
                        $price1 = $price;
                        $data['actualPrice'] = $actualPrice;
                        $data['price'] = $price;
                        $data['discount'] = $this->calculateDie($price1,'no');
                        $data['discountVal'] =(($price1 / 100) * $data['discount']);
                        $data['diecode'] = $diecode['code'];
                        $this->updateRecord($data);

                          echo json_encode(array('response'=>'yes','data'=>$data));
//                        }else{
//                            //echo 'else';exit;
//
//                        }

                    }else{
                        $data['message'] = $this->sendMessage($actualPrice);
                        echo json_encode(array('response'=>'no','data'=>$data));
                    }
                }else{
                    $data['message'] = 'We Never Print this '.$_REQUEST['shapes'].'Shape';
                    echo json_encode(array('response'=>'no','data'=>$data));
                }
            }
        }
        else{

            if((isset($diecode['message1']))  ){
                $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$_REQUEST['ID']."'")->result();
                $record[0]->die_code = $diecode['die'];
                $this->db->update('flexible_dies_info', $record[0], array('CartID' => $_REQUEST['ID']));
                $data['message1'] = $diecode['message1'];
                //print_r($data);exit;
                echo json_encode(array('response'=>'no','data'=>$data));
            }
            elseif($diecode['message']){

                $data['message'] = $diecode['message'];
                echo json_encode(array('response'=>'no','data'=>$data));
            }
            else{
                $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$_REQUEST['ID']."'")->result();
                $record[0]->die_code = '';
                $this->db->update('flexible_dies_info', $record[0], array('CartID' => $_REQUEST['ID']));
                $data['message'] = 'No Die Code For This  ..';
                echo json_encode(array('response'=>'no','data'=>$data));
            }

        }

    }



    public function updateClick(){


        //print_r($this->calculate->getNearestMatch($calculate,$_REQUEST['formats'],$_REQUEST['shapes']));


        if($this->input->post('quo') == 'quo'){
            $record = $this->db->query("SELECT * FROM flexible_dies_info where QID = '".$_REQUEST['serlno']."'")->result();
            $record[0]->update_click = $record[0]->update_click +1;
            $this->db->update('flexible_dies_info', $record[0], array('QID' => $_REQUEST['serlno']));
        }else{
            $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$_REQUEST['ID']."'")->result();
            $record[0]->update_click = $record[0]->update_click +1;
            $this->db->update('flexible_dies_info', $record[0], array('CartID' => $_REQUEST['ID']));
        }


        return true;
    }

    public function getWidth(){

        if($_REQUEST['formats'] == 'A3' || $_REQUEST['formats'] == 'SRA3' || $_REQUEST['formats'] == 'A4'){
            if($_REQUEST['shapes'] == 'Circle' || $_REQUEST['shapes'] == 'Square'){
                return $_REQUEST['sizes'] + $_REQUEST['sizes'] + $_REQUEST['sizes'] + $_REQUEST['sizes'];
            }elseif($_REQUEST['shapes'] == 'Oval' || $_REQUEST['shapes'] == 'Rectangle'){
                return ($_REQUEST['widths'] + $_REQUEST['widths']) + ($_REQUEST['heights'] + $_REQUEST['heights']);
            }else{
                $data['message'] = 'We Never Provide Any Die In This Shape';
                return $data;
            }
        }
        else{
            if($_REQUEST['formats'] == 'Roll'){
                if($_REQUEST['shapes'] == 'Circle'){
                    return ($_REQUEST['widths'] + $_REQUEST['widths']) * 2;
                }else{
                    return ($_REQUEST['widths'] + ($_REQUEST['heights'])) * 2;
                }

            }
            else{
                $data['message'] = 'We Never Provide Any Die In This Shape';
                return $data;
            }

        }
    }

    public function getKey($keys,$width){

        for($i=2;$i < sizeof($keys);$i++){
            $value = explode('cir_',$keys[$i])[1];
            if($value == $width || $value > $width){
                return  $keys[$i];
            }
        }
        return true;
    }

    public function calculateDie($priceValue,$con){

        $condition = ($_REQUEST['shapes'] == 'Circle' || $_REQUEST['shapes'] == 'Square')?[$_REQUEST['sizes'],$_REQUEST['sizes']]:[$_REQUEST['widths'],$_REQUEST['heights']];

        $records   = $this->getCategorySize($condition[0],$condition[1]);
        $value     = $this->getNearestValue($records,$this->input->post('sizes'));
        $diff      = ($this->input->post('sizes')) - ($value);
        $myRecords = $this->getDiePrice($diff,$priceValue);
       // print_r($myRecords);exit;
        if((isset($myRecords[0])) && $myRecords[0]['price'] >0){
            if($con == 'yes'){
                $this->updateRecord(array('discount'=>$myRecords[0]['price']),$priceValue);
            }

            return $myRecords[0]['price'];
        }else{
            return $myRecords[0]['price'] = 0;
        }

    }

    public function updateTempDis($discount){

        if($this->input->post('quo') == 'quo'){

            $record = $this->db->query("SELECT * FROM quotationdetails where SerialNumber = '".$_REQUEST['ID']."'")->result();
            $record[0]->temp_dis = $discount;
            $this->db->update('quotationdetails', $record[0], array('SerialNumber' => $_REQUEST['ID']));

        }else{
            $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$_REQUEST['ID']."'")->result();
            $record[0]->temp_dis = $discount;
            $this->db->update('flexible_dies_info', $record[0], array('CartID' => $_REQUEST['ID']));
        }


        return true;
    }

    public function updateRecord($values ,$actualPrice=null){

        //print_r($values);exit;
        //print_r($this->calculate->getNearestMatch($calculate,$_REQUEST['formats'],$_REQUEST['shapes']));
        if($this->input->post('quo') == 'quo'){
            $record = $this->db->query("SELECT * FROM flexible_dies_info where QID = '".$_REQUEST['serlno']."'")->result();
        }else{
            $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$_REQUEST['ID']."'")->result();
        }

        $temp = $this->db->query("SELECT * FROM temporaryshoppingbasket where ID = '".$_REQUEST['ID']."'")->result();
        //print_r($record);exit;
        $record[0]->die_code = $values['diecode'];
        $record[0]->temp_dis = (isset($values['discount']))?$values['discount']:$record[0]->discount;
        $record[0]->discount_val = (isset($values['discountVal']))?$values['discountVal']:$record[0]->discount_val;
        if($this->input->post('quo') != 'quo') {
            $temp[0]->UnitPrice = (isset($values['price'])) ? $values['price'] : $temp[0]->UnitPrice;
            $temp[0]->TotalPrice = (isset($values['price'])) ? $values['price'] : $temp[0]->TotalPrice;
        }
        if($this->input->post('quo') == 'quo'){

            $srlno = $this->input->post('serlno');
            $query = $this->db->query("SELECT * from quotationdetails WHERE SerialNumber = '$srlno' ");
            $quoDetail = $query->row_array();
            $casPrice = (isset($values['price'])) ? $values['price'] : '0.00';
            $scorecord['Price'] =$casPrice;
            $scorecord['ProductTotalVAT'] = $casPrice;
            $scorecord['ProductTotal'] = $casPrice;

            $this->db->where('SerialNumber', $srlno);
            $this->db->update('quotationdetails', $scorecord);
            $this->db->where('serial', $srlno);
            $this->db->delete('flexible_pricing');
            $this->db->insert('flexible_pricing',array('serial'=>$srlno,'Operator'=>$this->session->userdata('UserID'),'supplier'=>'custom_die','price'=>$casPrice,'sprice'=>$casPrice,'status'=>'1'));




            $this->db->update('flexible_dies_info', $record[0], array('QID' => $_REQUEST['serlno']));

        }else{
            $this->db->update('flexible_dies_info', $record[0], array('CartID' => $_REQUEST['ID']));
            $this->db->update('temporaryshoppingbasket', $temp[0], array('ID' => $_REQUEST['ID']));
        }

        $this->home_model->save_logs('calculate_customdie',$temp[0]);  //SAVE LOG
        return true;
    }

//    public function updateRecord($values ,$actualPrice=null){
//
//        //print_r($values);exit;
//        //print_r($this->calculate->getNearestMatch($calculate,$_REQUEST['formats'],$_REQUEST['shapes']));
//        $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$_REQUEST['ID']."'")->result();
//        $record[0]->width = ($this->input->post('widths'))?$this->input->post('widths'):$record[0]->width;
//        $record[0]->height = ($this->input->post('heights'))?$this->input->post('heights'):$record[0]->height;
//        $record[0]->die_code = $values['diecode'];
//        $record[0]->discount = (isset($values['discount']))?$values['discount']:$record[0]->discount;
//        $record[0]->across = ($this->input->post('across') !=null )?$_REQUEST['across']:$record[0]->across;
//        $record[0]->around = ($this->input->post('around') !=null )?$_REQUEST['around']:$record[0]->around;
//        $record[0]->discount_val = (isset($values['discount']))?(($actualPrice / 100) * $values['discount']):$record[0]->discount_val;
//        //print_r($record);exit;
//        if($this->input->post('quo') == 'quo'){
//            $this->db->update('flexible_dies_info', $record[0], array('QID' => $_REQUEST['ID']));
//        }else{
//            $this->db->update('flexible_dies_info', $record[0], array('CartID' => $_REQUEST['ID']));
//        }
//
//
//        return true;
//    }

    public function sendMessage($actualPrice){

        if($_REQUEST['labelss'] > 500){
            return 'We Print Only 500 Labels Thank you ...';
        }
        elseif($actualPrice ==0){
            return 'This Size is Not Available Right Now ...';
        }
    }

    public function getSheetFormat(){
        return $this->db->select($this->table.'.CategoryID,'.$this->table.'.labelCategory')
            ->from($this->table)
            ->where('labelCategory is  NOT NULL')
            ->order_by($this->table.'.labelCategory','DESC')
            ->group_by($this->table.'.labelCategory')
            ->get()->result();
    }

    public function getShape($sheetId){
        return $this->db->select($this->table.'.CategoryID,'.$this->table.'.Shape')
            ->from($this->table)
            ->like($this->table.'.labelCategory',$sheetId)
            ->order_by($this->table.'.Shape','DESC')
            ->group_by($this->table.'.Shape')
            ->get()->result();
    }

    public function getSize($shape){

        if($shape == 'Circle' || $shape == 'Square'){
            $select = $this->table.'.Width,';
        }else{
            $select = $this->table.'.Width,'.$this->table.'.Height';
        }
        return $this->db->select($select)
            ->from($this->table)
            ->like($this->table.'.labelCategory',$shape)
            ->get()->result();
    }

    public function getPrice($labels,$width){
        $table = 'calculated_price';
        $where = $table.'.no_lables'.' = '.$labels .' or '.$table.'.no_lables > '.$labels;
        return $this->db->select($table.'.*')
            ->from($table)
            ->where($where)
            ->limit(1)
            ->get()->result_array();
    }

    public function getDiePrice($size,$priceValue){
        $condition = $this->makeCondition($priceValue);
        //echo $size;exit;
        $table = 'calculated_die_price';
        $where = 'CAST(size AS CHAR) >= CAST('.$size.' AS CHAR)';
        return $this->db->select($table.'.*')
            ->from($table)
            ->where('price_range',$condition)
            ->where($where)
            ->limit(1)
            ->get()->result_array();
    }

    public function getCategorySize($width,$height){

        $table = 'category';
        $where = 'CAST(Width AS decimal) >= CAST('.$width.' AS decimal) and CAST(Height AS decimal) <= CAST('.$height.' AS decimal)';
        return $this->db->select($table.'.Width,'.$table.'.Height')
            ->from($table)
            ->where($where)
            ->group_by('Width ,Height')
            ->limit(3)
            ->get()->result_array();

    }

    public function getNearestMatch($width,$height,$format,$shape,$check=null){

      
        if($shape == 'Circle'){
            $height = $width;
            $shape = 'Circular';
        }elseif($shape == 'Square'){
            $height = $width;
            $shape = 'Square';
        }
      

        $format = $this->makeFormat($format);
      
        $keyValue = "";
        $calculate = ($width + $height) * 2;
       
     
        $result = $this->db->select("DieCode as code FROM `category` where  labelCategory = '".$format."' AND CategoryActive = 'Y' AND Shape = '".$shape."' AND Width = ".$width." AND Height = ".$height."   ORDER BY DieCode DESC LIMIT 1 ")->get();
        if($result->num_rows()){
            $dieCode = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$_REQUEST['ID']."'")->result();

            $result2 = $result->result_array();
            //print_r($result2);exit;
            if($check === 'true' /*&& ($result[0]['DieCode'] == $dieCode[0]->die_code)*/){
                return $this->removeExtra($result2);
            }else{

                $die =$this->removeExtra($result->result_array());
                $data['message1'] = 'This label shape and size matches product '.$die['code'].' on the website.';
                $data['die'] = $die['code'];
                return $data;
            }

        }else{

            $diff = (($calculate /100) * 1.5); //3
            //echo $diff;exit;
            $records = $this->db->select("(Width + Height)as total,DieCode as code FROM `category` where  labelCategory = '".$format."' AND CategoryActive = 'Y' AND Shape = '".$shape."'  HAVING total <=> ".$calculate."  ORDER BY total ")->get()->result_array();
            $closest = null;
            //print_r($records);exit;
            foreach ($records as $key=>$record){
                if ($closest === null || abs($calculate - $closest) > abs($record['total'] - $calculate)) {
                    $closest = $record['total'];
                    $keyValue = $key;
                }
            }

            if($format != 'Roll'){
                if(!empty($records)){
                    return $this->removeExtra($records[$keyValue]);
                }else{
                    $data['message'] = 'We have no die for this calculation..';
                    return $data;
                }

            }else{
                //echo $records[$keyValue]['total'] - $calculate;exit;
                if(($records[$keyValue]['total'] - $calculate) <= $diff){
                    //echo 'her';exit;
                    return $this->removeExtra($records[$keyValue]);
                }else{
                    //echo 'else';exit;
                    $data['message'] = 'We have no die for this calculation..';
                    return $data;
                }
            }


        }
    }

    public function makeFormat($format){
        if($format == 'A3'){
            return 'A3 Label';
        }
        else if($format == 'A4'){
            return 'A4 Labels';
        }
        else if($format == 'SRA3'){
            return 'SRA3 Label';
        }
        else if($format == 'Roll'){
            return 'Roll Labels';
        }
    }

    public function removeExtra($record){
       // print_r($record);exit;
        $value = explode('-',(isset($record[0]))?$record[0]['code']:$record['code'])[1];
        $newRecord['total'] = (isset($record[0]['total']))?$record[0]['total']:0;
        $newRecord['code'] = $value;
        return $newRecord;
    }

    public function getProductId($mefatureCode){
        return  $this->db->query("select ProductID,LabelsPerSheet from products where ManufactureID LIKE '%".$mefatureCode."%'")->row_array();

    }

    public function makeCondition($price){
        if($price < 100){
            return '0_100';
        }
        else if($price < 200){
            return '100_200';
        }
        else if($price < 300){
            return '200_300';
        }
        else if($price < 400){
            return '300_400';
        }
        else if($price < 500){
            return '400_500';
        }
        else if($price < 600){
            return '500_600';
        }
        else if($price < 700){
            return '600_700';
        }
        else if($price < 800){
            return '700_800';
        }
        else if($price < 900){
            return '800_900';
        }
        else if($price < 1000){
            return '900_1000';
        }
        else if($price > 1000){
            return '1000';
        }
    }

    public function getNearestValue($records,$size)
    {
        //echo $size;
        //echo '<pre>';
       // print_r($records);exit;
        $closest = null;
        foreach ($records as $item){
            if($size == $item['Width']){
                $closest = $size;
                break;
            }
            else{
                if ($closest === null || abs($size - $closest) > abs($item['Width'] - $size)) {
                    $closest = $item['Width'];
                }
            }
        }
        return $closest;
    }

    public function getTempDisVal($id){

        if($this->input->get('quo') == 'quo'){
            $qry = $this->db->query("select * from quotationdetails where SerialNumber = '".$id."'")->result_array();
        }else{
            $qry = $this->db->query("select * from flexible_dies_info where CartID = $id")->result_array();
        }

        echo json_encode($qry);
    }

    public function cancelCart(){
        $this->db->where('ID', $this->input->post('cartId'));
        $this->db->delete('temporaryshoppingbasket');
        return true;
    }










































































































































}