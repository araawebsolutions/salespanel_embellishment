<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class myPriceModel extends CI_Model
{

// for plain roll price
    function calculatePlainRollPrice($manufature = NULL, $rolls = NULL, $label = NULL)
    {

        if (isset($rolls) and $rolls > 0 and isset($label) and $label > 99) {

            $total_price = $this->home_model->calculate_material($manufature, $label, $rolls);
            $total_price = $total_price / 0.94; // 6% increment yearly

            /******** price uplift ********************************/


            $total_price = $this->home_model->check_price_uplift($total_price);


            /********************** price uplift **************/

            $final_price = sprintf('%.2f', round($total_price, 2));

            $unit_price = sprintf('%.2f', round($total_price / $rolls, 2));

            $perlabel = number_format(($unit_price / $label) * 100, 2);

            return $data = array('perlabel' => $perlabel, 'price' => $final_price, 'unit_prcie' => $unit_price, 'Labels' => $label);
        } else {
            return $data = array('perlabel' => 0.00, 'price' => 0.00, 'unit_prcie' => 0.00, 'Labels' => 0.00);

        }
    }


// for printed roll and  sheet price
    function calculatePrintedRollPrice($data)
    {
        //print_r($data);
        $free_artworks = 1;
        $pressproofprice = 0.00;
        $labels_per_rolls = '';
        $promotiondiscount = 0.00;
        $plainlabelsprice = 0.00;
        $label_finish = 0.00;

        $producttype = $data['producttype'];
        $labels = $data['labels'];
        $persheets = $data['persheets'];
        $menu = $data['menu'];
        $design = $data['design'];
        $qty = @$data['qty'];
        $brand = $data['brand'];

        if (preg_match("/Mono/", $data['labeltype'])) {
            $labeltype = "Mono";
        } else if (preg_match("/White/", $data['labeltype'])) {
            $labeltype = "Fullcolour+White";
        } else {
            $labeltype = "Fullcolour";
        }

        if ($this->input->post('regmark') == "Y") {
            $labeltype = "Mono";
        }

        if ($producttype == 'sheet') {

            $pridsheet = $this->db->query("select LabelsPerSheet from products WHERE 
				`ManufactureID` LIKE '" . $menu . "'")->row_array();

            if (isset($data['qty']) && $data['qty'] > 0) {
                $sheets = $data['qty'];
            } else {
                $sheets = ceil($labels / $persheets);
            }
            $ProductBrand = $this->ProductBrand($menu);
            $data = $this->product_model->ajax_price($sheets, $menu, $ProductBrand);

            $price = $data['custom_price'];
            $printprice = 0.00;
            $designprice = 0.00;
            $free_artworks = 1;

            if ($labeltype == 'Mono' || $labeltype == 'Fullcolour') {
                $printprice = $this->home_model->calculate_printed_sheets($sheets, $labeltype, $design, $brand, $menu);

               $free_artworks = $printprice['artworks'];
                $designprice = $printprice['desginprice'];
                $printprice = $printprice['price'];
                //$printprice = 0;
            }
        } else {


            $pressproof = $data['pressproof'];
            $rollfinish = $data['finish'];

            //$rolls = (isset($data['rolls']) and $data['rolls']!='')?$data['rolls']:'';
            $prid = $this->db->query("select LabelsPerSheet from products WHERE 
				`ManufactureID` LIKE '" . $menu . "'")->row_array();

            $min_qty = $this->home_model->min_qty_roll($menu);

            //$response = $this->home_model->rolls_calculation($min_qty, $persheets, $labels);
            $response = $this->home_model->rolls_calculation($min_qty, $prid['LabelsPerSheet'], $labels);
            $labels = $response['total_labels'];
            $labels_per_rolls = $response['per_roll'];
            $sheets = $response['rolls'];
            
            
            //echo '<pre>'; print_r($response);


            $collection['labels'] = $labels;
            $collection['manufature'] = $menu;
            $collection['finish'] = $data['finish'];
            $collection['rolls'] = $sheets;
            $collection['labeltype'] = $labeltype;


            //echo '<pre>'; print_r($collection);
            $price_res = $this->home_model->calculate_printing_price($collection);
            $promotiondiscount = $price_res['promotiondiscount'];
            $plainlabelsprice = $price_res['plainprice'];
            $label_finish = $price_res['label_finish'];


            //137.51*1.1 = 151.261
            $price = $plainprice = $price_res['final_price'];

            /*************** Roll Labels Price *************/
            $printprice = 0.00;
            $designprice = 0.00;
            $free_artworks = 10;
            if ($pressproof == 1) {
                $pressproofprice = 50.00;
            }
            /*************** Roll Labels Price *************/

            if ($qty > $response['rolls']) {
                $add_rolls = $qty - $response['rolls'];
                $additional_cost = $this->home_model->additional_charges_rolls($add_rolls);
                $price = $price + $additional_cost;
            }
        }

        //$('.nlabelfilter').trigger('mouseover');

        $delivery_txt = $this->shopping_model->delevery_txt();

        /*************** Roll Labels Wholesale Price *************/
        $userID = $this->session->userdata('Order_person');
        $userID = (isset($_POST['customerId']) and !empty($_POST['customerId'])) ? $_POST['customerId'] : $userID;
        if ((isset($userID) and !empty($userID))) {
            //$price = $this->quotationModal->apply_discount($userID,$menu,$price,'roll');
        }
        /*************** Roll Labels Wholesale Price *************/

        $plainprice = number_format($price, 2, '.', '');
        $price = $designprice + $printprice + $price + $pressproofprice;
        $price = number_format($price, 2, '.', '');

        $pressproofprice = number_format($pressproofprice, 2, '.', '');


        $delivery_txt = '';
        if ($price > 25) {
            $delivery_txt = '<b> Free Delivery </b>';
        }
        // echo $price.' = '.$labels;exit;
        if ($labels) {
            $priceperlabels = number_format(($price / $labels), 3, '.', '');
        } else {
            $priceperlabels = '';
        }
        $price_array = array(
            'price' => 0.00,
            'plainprint' => 0.00,
            'plainprice' => $plainprice,
            'printprice' => $printprice,
            'designprice' => $designprice,
            'pressproof' => $pressproofprice,
            'priceperlabels' => $priceperlabels,
            'artworks' => $free_artworks,
            'nodesing' => $design,
            'sheets' => $sheets,
            'rolls' => $sheets,
            'labels' => $labels,
            'labels_per_rolls' => $labels_per_rolls,
            'delivery_txt' => $delivery_txt,
            'promotiondiscount' => $promotiondiscount,
            'plainlabelsprice' => $plainlabelsprice,
            'label_finish' => $label_finish,
            'free' => $free_artworks);
        return $price_array;


    }

// for plain sheet
    function calculatePlainSheetPrice($qty, $mafatureid)
    {
        $ProductBrand = $this->ProductBrand($mafatureid);
        $id = $mafatureid;
        error_reporting(0);


        if (substr($id, -2, 2) == 'XS') {
            $row = $this->db->query("Select count(*) as total,`Price` from xmass_prices where Qty LIKE '" . $qty . "' LIMIT 1");
            $result = $row->row_array();
            if ($result['total'] == 1) {
                $custom_price = number_format($result['Price'] / 1.2, 2, '.', '');
                $custom_price = number_format($custom_price, 2, '.', '');
                $data = array('custom_price' => $custom_price);
            } else {
                $data = array('custom_price' => 4.15);
            }
            return $data;
        }

        $roll = $this->product_model->Is_ProductBrand_roll($id);

        if ($roll['Roll'] == 'yes') {
            $custom_price = $this->home_model->calclateprice($id, $qty, $roll['LabelsPersheet']);
            $custom_price = number_format(round($custom_price['final_price'], 2), 2, '.', '');
            $custom_price = number_format(round($custom_price, 2), 2, '.', '');
            $data = array('custom_price' => $custom_price);
            return $data;
        }

        if ($roll['ProductBrand'] == 'Application Labels') {
            $response = $this->Product_model->lba_pack_details(array('ManufactureID' => $id));
            $qty = $qty * $response['packsize'];
            if ($qty < 25) {
                return $this->Product_model->calculate_lba_price($qty, $id);
            }
        }


        $case = '';
        $q = $this->db->query("select tbl.ManufactureID,tbl.BatchID,tbl.SetupCost,tbl.SheetPrice,batch.BatchQty from tbl_product_batchprice tbl,tbl_batch batch where tbl.ManufactureID='$id' and tbl.BatchID= batch.BatchID ORDER BY  batch.BatchQty Asc ");
        $row = $q->result_array();
//        $j = 0;
//        $row = '';
//
//        foreach ($res as $row[]) {
//
//        }

        $arrsize = count($row);

        $flag = 0;

        for ($traverse = 0; $traverse < $arrsize - 1; $traverse++) {

            if ($qty < 100) {
                $flag = 1;
                $oppertunity_quan = $row[0]['BatchQty'];
                $oppertunity_sheet = $row[0]['SheetPrice'];
                $oppertunity_total = $oppertunity_quan * $oppertunity_sheet;
                $sheetprice = $row[0]['SheetPrice'];
                $setupcost = $row[0]['SetupCost'];
                $custom_price = ($sheetprice * $qty) + $setupcost;
            }
            if ($qty >= $row[$traverse]['BatchQty'] && $qty < $row[$traverse + 1]['BatchQty']) {

                $flag = 1;
                $batch = $row[$traverse]['BatchQty'];

                $setupcost = $row[$traverse + 1]['SetupCost'];
                if ($qty == $row[$traverse]['BatchQty']) {
                    $sheetprice = $row[$traverse]['SheetPrice'];
                    $batch = $row[$traverse]['BatchQty'];
                    $custom_price = ($sheetprice * $qty);
                    break;
                } else {
                    $sheetprice = $row[$traverse + 1]['SheetPrice'];
                    $sheetprice1 = $row[$traverse]['SheetPrice'];
                    $batch = $row[$traverse]['BatchQty'];
                    $custom_price = ($sheetprice * $qty) + $setupcost;
                    $custom_price1 = $sheetprice1 * $batch;
                    if ($custom_price < $custom_price1) {

                        $custom_price = $custom_price1 + (($qty - $batch) * $sheetprice);

                    }

                    if (substr($row[$traverse]['ManufactureID'], 0, 2) == "SR" || substr($row[$traverse]['ManufactureID'], 0, 2) == "sr") {
                        $custom_price = $custom_price1 + (($qty - $batch) * $sheetprice);
                    }
                    $oppertunity_quan = $row[$traverse + 1]['BatchQty'];
                    $oppertunity_sheet = $row[$traverse + 1]['SheetPrice'];
                    $oppertunity_total = $oppertunity_quan * $oppertunity_sheet;


                    break;
                }
            }

        }


        if ($flag == 0) {
            $sheetprice = $row[$traverse]['SheetPrice'];
            $setupcost = $row[$traverse]['SetupCost'];
            if ($qty == $row[$traverse]['BatchQty']) {
                $batch = $row[$traverse]['BatchQty'];
                $custom_price = ($sheetprice * $qty);
                //  break;
            } else {
                $batch = $row[$traverse]['BatchQty'];
                $custom_price = ($sheetprice * $qty) + $setupcost;
                //  break;
            }
        }


        if ($roll['ProductBrand'] == 'Application Labels') {
            $printprice = $this->home_model->calculate_printed_sheets($qty, 'Fullcolour', 1, $ProductBrand);
            $custom_price = $custom_price + $printprice['price'];
        }


        $custom_price = $this->home_model->check_price_uplift($custom_price);


        $custom_price = number_format(round($custom_price, 2), 2, '.', '');

        $custom_price = number_format(round($custom_price, 2), 2, '.', '');
        $data = array('price' => $custom_price);
        return $data;
    }

    // for integrated labels
    function get_box_price($manufatureid, $box, $batch, $print, $productid = null)
    {
        $ProductBrand = $this->ProductBrand($manufatureid);
        $PlainPrice = "";
        $printprice = "";
        $designprice = "";
        $BlackPrice = "";
        $PrintPrice = "";
        $free_artworks = "";
        $design = "";
        $print_option = "";

        $array = array('print_price' => 0.00, 'plain_price' => 0.00, 'black_price' => 0.00, 'total' => 0.00);

        if (isset($manufatureid) and isset($box) and $box != 0) {
            $price = $this->home_model->single_box_price($manufatureid, $box, $batch);
            if (isset($print)) {
                if (preg_match('/Mono/', $print)) {
                    $print = 'black';
                } else if (preg_match('/Digital/', $print)) {
                    $print = 'printed';
                } else {
                    $print = "";
                }
            }

            if (is_array($price)) {
                if (isset($print) and $print != '') {
                    if (isset($cart_id) and $cart_id != '') {
                        $design = $this->get_uploaded_number_design($cart_id, $productid);
                    } else {
                        $design = $this->get_number_design($productid);
                    }

                    if ($print == "black") {
                        $printprice = $this->home_model->calculate_printed_sheets($box, 'Mono', $design, $ProductBrand);
                        $printprice['price'] = $this->home_model->currecy_converter($printprice['price'], 'yes');
                        $PrintPrice = 0.00;
                        $BlackPrice = sprintf('%.2f', round($printprice['price'], 2));
                        $print_option = "Mono";
                    } else if ($print == "printed") {
                        $printprice = $this->home_model->calculate_printed_sheets($box, 'Fullcolour', $design, $ProductBrand);
                        $printprice['price'] = $this->home_model->currecy_converter($printprice['price'], 'yes');

                        $PrintPrice = sprintf('%.2f', round($printprice['price'], 2));
                        $BlackPrice = 0.00;
                        $print_option = "Fullcolour";
                    } else {
                        $PrintPrice = 0.00;
                        $BlackPrice = 0.00;
                    }
                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $PrintPrice;
                }

                if ($box != $price['Sheets']) {
                    $perbox = $price['PlainPrice'] / $price['Box'];
                    $acc_boxes = $box / $batch;
                    $calculated_price = $acc_boxes * $perbox;
                    $price['PlainPrice'] = $calculated_price;
                }

                $plain_value = $price['PlainPrice'] = $this->home_model->currecy_converter($price['PlainPrice'], 'yes');
                $printprice = $this->home_model->currecy_converter($printprice, 'yes');
                $designprice = $this->home_model->currecy_converter($designprice, 'yes');

                $printed_price = $PrintPrice + $BlackPrice;
                $plain_price = $PlainPrice;
                $onlyprintprice = $printed_price;
                $total = $price['PlainPrice'] + $printed_price + $designprice;

                $dpd = $price['dpd'];

                $total = sprintf('%.2f', round($total, 2));
                $PlainPrice = sprintf('%.2f', round($price['PlainPrice'], 2));

                $array = array('print_price' => $printed_price,
                    'plain_price' => $PlainPrice,
                    'black_price' => $BlackPrice,
                    'total' => $total,
                    'per_sheet' => sprintf('%.4f', round($total / $box, 4)),
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'dpd' => number_format($dpd, 2),

                    'halfprintprice' => number_format($printed_price * 2, 2),
                    'printprice' => number_format($onlyprintprice, 2),
                    'designprice' => $designprice,
                    'artworks' => $free_artworks,
                    'nodesing' => $design,
                    'print_option' => $print_option,
                );
            }
        }
        return $array;
    }

    function get_uploaded_number_design($cartid, $productid)
    {
        $sid = $this->session->userdata('session_id') . '-PRJB';
        $query = $this->db->query("select count(*) as total from integrated_attachments WHERE SessionID LIKE '" . $sid . "' AND
		 ProductID=$productid AND status LIKE 'confirm' AND  CartID LIKE '" . $cartid . "'");
        $row = $query->row_array();
        if (isset($row['total']) and $row['total']) return $row['total'];
        else return 0;
    }

    function get_number_design($productid)
    {
        $SID = $this->shopping_model->sessionid();
        $query = $this->db->query("select count(*) as total from integrated_attachments WHERE SessionID LIKE '" . $SID . "' AND ProductID= productid AND status LIKE 'temp' ");
        $row = $query->row_array();
        if (isset($row['total']) and $row['total']) return $row['total'];

        else return 0;
    }


    public function getPriceForQuotation($data, $productId = null)
    {
        $result = "";
        $ProductBrand = $this->ProductBrand($this->input->post('manfactureID'));

        if ($data['brand'] == 'Integrated Labels') {
            $quota = $this->getQuotationDetail($data['serialno']);

            $batch = (preg_match('/250 Sheet Dispenser Packs/is', $quota->ProductName)) ? 250 : 1000;

            $qty = $this->input->post('qty');
            $print = $this->input->post('digital');
            //echo $productId;exit;
            $result = $this->get_box_price($this->input->post('manfactureID'), $qty, $batch, $print, $productId);

            // print_r($result);exit;

        } elseif ($data['printing'] != 'Y' && $data['brand'] == 'Roll Labels') {
            //print_r($data);exit;
            $result = $this->calculatePlainRollPrice($data['manfactureId'], $data['rolls'], $data['labels']);
        } elseif ($data['printing'] != 'Y' && $data['brand'] != 'Roll Labels') {

//            $result = $this->calculatePlainSheetPrice($data['qty'],$data['manfactureId']);
            $result = $this->product_model->ajax_price($data['qty'], $data['manfactureId'], $ProductBrand);
            $result = [
                "price" => $result["custom_price"]
            ];

        } else {
             //print_r($data);exit;
            $firstPrice = $this->calculatePrintedRollPrice($data);
            //print_r($firstPrice);exit;
            $result = $this->sendResponse($firstPrice, $data);
            // print_r($convertedPrice);exit;
            //$result = $this->checkForWholeSaleCustomer($convertedPrice,$data['customerId'],$data['producttype'],$data['printing']);


            $A4Printingsss = array(
                'Free' => $firstPrice['free']
            );
            $result = array_merge($result, $A4Printingsss);

            //print_r($result);exit;
            return $result;
        }

        return $this->sendResponse($result, $data);

    }

    public function getPriceForCart($data, $productId = null)
    {
        $result = "";
        $ProductBrand = $this->ProductBrand($this->input->post('manfectureId'));

        if ($data['brand'] == 'Integrated Labels') {
            $cart = $this->getCartDetail($data['cartId']);
            $qty = $this->input->post('qty');
            $print = $this->input->post('digital');

            $result = $this->get_box_price($this->input->post('manfectureId'), $qty, $cart->orignalQty, $print, $productId);
            //print_r($result);exit;
        } elseif ($data['printing'] != 'Y' && $data['brand'] == 'Roll Labels') {
            //print_r($data);exit;
            $result = $this->calculatePlainRollPrice($data['manfactureId'], $data['rolls'], $data['labels']);
        } elseif ($data['printing'] != 'Y' && $data['brand'] != 'Roll Labels') {

//            $result = $this->calculatePlainSheetPrice($data['qty'],$data['manfactureId']);
            $result = $this->product_model->ajax_price($data['qty'], $data['manfactureId'], $ProductBrand);
            $result = [
                "price" => $result["custom_price"]
            ];
        } else {
            // print_r($data);exit;
            $firstPrice = $this->calculatePrintedRollPrice($data);
            //print_r($record);exit;
            $result = $this->sendResponse($firstPrice, $data);
            // print_r($convertedPrice);exit;
            //$result = $this->checkForWholeSaleCustomer($convertedPrice,$data['customerId'],$data['producttype'],$data['printing']);

            //print_r($result);exit;
            return $result;
        }

        return $this->sendResponse($result, $data);

    }

    public function getPriceForOrder($data, $productId = null)
    {
        $ProductBrand = $this->ProductBrand($this->input->post('manfectureId'));

        if ($data['brand'] == 'Integrated Labels') {
            $quota = $this->getOrderDetail($data['serialno']);

            $qty = $this->input->post('qty');
            $print = $this->input->post('digital');
            
             $batch = (preg_match('/250 Sheet Dispenser Packs/is',  $quota->labels)) ? 250 : 1000;

            //echo $quota->labels;exit;
            $result = $this->get_box_price($this->input->post('manfectureId'), $qty, $batch, $print, $productId);

        } elseif ($data['printing'] != 'Y' && $data['brand'] == 'Roll Labels') {
            //print_r($data);exit;

            $result = $this->calculatePlainRollPrice($data['manfactureId'], $data['rolls'], $data['labels']);
        } elseif ($data['printing'] != 'Y' && $data['brand'] != 'Roll Labels') {

           // $result = $this->calculatePlainSheetPrice($data['qty'],$data['manfactureId']);
            $result = $this->product_model->ajax_price($data['qty'], $data['manfactureId'], $ProductBrand);
            $result = ["price" => $result["custom_price"] ];
           
        } else {
             //print_r($data);exit;
            $firstPrice = $this->calculatePrintedRollPrice($data);
            $result = $this->sendResponse($firstPrice, $data);

           $A4Printingsss = array(
                'Free' => $firstPrice['free']
           );
            $result = array_merge($result, $A4Printingsss);


            //print_r($result);exit;
            //$result = $this->checkOrderWholeSaleCustomer($record,$data['customerId'],$data['producttype'],$data['printing']);

            // print_r($result);exit;
            return $result;
        }

        return $this->sendResponse($result, $data);

    }

    function ProductBrand($id)
    {
        $query = $this->db->query("select  ProductBrand from products  where ManufactureID='" . $id . "'");
        $res = $query->row_array();
        return $res['ProductBrand'];
    }

    public function checkOrderWholeSaleCustomer($result, $customerId, $productType, $plain_print = null)
    {
        // print_r($result);exit;
        $customer = $this->getCustomer($customerId);
        $myprice = '';

        if ($customer->wholesale == 'wholesale' && $productType == 'Rolls' && $plain_print == 'Y') {

            $price = $result['plainprice'] + $result['designprice'] + $result['pressproof'];

            $custPrice['plainPrice'] = number_format(($price - (($price * $customer->printed_discount) / 100)), 2);
            $custPrice['printPrice'] = 0.00;
            $custPrice['totalPrice'] = number_format(($price - (($price * $customer->printed_discount) / 100)), 2);

            return $custPrice;

        } else {
            if ($productType == 'Rolls') {
                $myprice = $result['plainprice'] + $result['designprice'] + $result['pressproof'];
            } else {
                $myprice = $result['plainprice'];
            }


            $custPrice['plainPrice'] = $myprice;
            $custPrice['printPrice'] = ($productType == 'Rolls') ? '0.00' : $result['printprice'];
            $custPrice['totalPrice'] = $result['plainprice'] + $result['printprice'];

            return $custPrice;
        }

    }

    public function getPrice($serialNo = null, $orderNumber, $manufactureId, $data = null)
    {

        return $this->makeParamAndGetRecord($this->getWholeRecord($serialNo, $orderNumber, $manufactureId), $data);
    }

    public function makeParamAndGetRecord($record, $data)
    {
        $ProductBrand = $this->ProductBrand($data['manfactureId']);

        $data['manfactureId'] = $record->ManufactureID;
        if ($record->ProductBrand == 'Integrated Labels') {
            $box = (preg_match('/250 Sheet Dispenser Packs/is', $record->ProductName)) ? 250 : 1000;
            $data['qty'] = (isset($data['qty']) && $data['qty'] > 0) ? $data['qty'] : $data['statics']->totalQuantity;
            $result = $this->get_box_price($record->ManufactureID, $data['qty'], $box, $record->Print_Type, $record->ProductID);


        } elseif ($record->ProductBrand == 'Roll Labels' && $record->Printing != 'Y') {
            // if you want to count with custom price with custom data

            if (isset($data['qty']) || isset($data['statics'])) {
                //data static variable use when on checkout tab use change from plain to printed or printed to plain
                $data['qty'] = (isset($data['qty'])) ? $data['qty'] : $data['statics']->totalQuantity;
                // print_r($record->LabelsPerRoll);exit;
                $result = $this->calculatePlainRollPrice($record->ManufactureID, $data['qty'], $record->LabelsPerRoll);
                //print_r($result);exit;
            } else {
                $result = $this->calculatePlainRollPrice($record->ManufactureID, $record->Quantity, $record->LabelsPerRoll);
            }
        } elseif ($record->ProductBrand != 'Roll Labels' && $record->Printing != 'Y') {

            if (isset($data['qty']) || isset($data['statics'])) {
                //data static variable use when on checkout tab use change from plain to printed or printed to plain
                $data['qty'] = (isset($data['qty'])) ? $data['qty'] : $data['statics']->totalQuantity;
//                $result = $this->calculatePlainSheetPrice($data['qty'],$data['manfactureId']);
                $result = $this->product_model->ajax_price($data['qty'], $data['manfactureId'], $ProductBrand);
                $result = [
                    "price" => $result["custom_price"]
                ];
                //echo '<pre>'; print_r($result); echo '</pre>';
            } else {

//                $result = $this->calculatePlainSheetPrice($record->Quantity,$record->ManufactureID);
                $result = $this->product_model->ajax_price($record->Quantity, $record->ManufactureID, $ProductBrand);
                $result = [
                    "price" => $result["custom_price"]
                ];
            }
        } else {

            $params = array(
                'labeltype' => $record->Print_Type,
                'labels' => (isset($data['statics'])) ? $data['statics']->totalLabels : $record->labels,
                //'design'=>(isset($record->Print_Design))?$record->Print_Design:$this->getNumberOfDesign($record->SerialNumber),
                'design' => $data['statics']->count,
                'menu' => $record->ManufactureID,
                'persheets' => (isset($data['statics']->per_shet_roll)) ? ($data['per_shet_roll']) : $record->LabelsPerSheet,
                'producttype' => ($record->ProductBrand == 'Roll Labels') ? 'Rolls' : 'sheet',
                'pressproof' => $record->pressproof,
                'finish' => $record->FinishType,
                'brand' => $record->ProductBrand,
                'qty' => @$data['qty'],
                'max_lbl' => $record->LabelsPerSheet
            );
            //print_r($params);exit;
            $price = $this->calculatePrintedRollPrice($params);

            $data['brand'] = $record->ProductBrand;
            $data['printing'] = $record->Printing;
            // print_r($result);exit;
            $myPrice = $this->sendResponse($price, $data);
            //print_r($myPrice);exit;
            $customerId = $this->session->userdata('customer_id');

            $result = $this->checkForWholeSaleCustomer($myPrice, $customerId, $params['producttype'], $record->Printing);
            return $result;
        }


        $data['brand'] = $record->ProductBrand;
        $data['printing'] = $record->Printing;
        $myPrice = $this->sendResponse($result, $data);


        return $myPrice;
    }

    public function checkForWholeSaleCustomer($result, $customerId, $productType, $plain_print = null)
    {

        $customer = $this->getCustomer($customerId);
        $customer = (array)$customer;
        //echo"<pre>";print_r($customer);echo"</pre>";exit;
        if (@$customer['wholesale'] == 'wholesale' && $productType == 'Rolls' && $plain_print == 'Y') {
            $result['plainPrice'] = number_format(($result['plainPrice'] - (($result['plainPrice'] * $customer->printed_discount) / 100)), 2);
            $result['printPrice'] = number_format(($result['printPrice'] - (($result['printPrice'] * $customer->printed_discount) / 100)), 2);
            $result['totalPrice'] = number_format(($result['totalPrice'] - (($result['totalPrice'] * $customer->printed_discount) / 100)), 2);

            return $result;

        } else {
            //echo"<pre>";print_r($result);echo"</pre>";exit;
            return $result;
        }

    }

    public function getCustomer($customerId)
    {
        $results = $this->db->select("c.*")
            ->from('customers as c')
            ->where('c.UserID', $customerId)
            ->get()->row();
        return $results;
    }

    public function sendResponse($result, $data = null)
    {
        // for integrated

        if ($data['brand'] == 'Integrated Labels') {
            $finalPrice = array(
                'plainPrice' => (isset($result['plain_price']) && $result['plain_price'] > 0) ? $result['plain_price'] : '0.00',
                'printPrice' => (isset($result['print_price']) && $result['print_price'] > 0) ? $result['print_price'] : '0.00',
                'totalPrice' => (isset($result['total']) && $result['total'] > 0) ? $result['total'] : '0.00',
            );

            return $finalPrice;
        }

        // for printed Roll
        if ($data['brand'] == 'Roll Labels' && $data['printing'] == 'Y') {
            $finalPrice = array(
                'plainPrice' => ($result['plainprice'] + $result['designprice'] + $result['pressproof']),
                'printPrice' => 0.00,
                'totalPrice' => ($result['plainprice'] + $result['designprice'] + $result['pressproof']));
            return $finalPrice;
        }
        //for plain Roll
        if ($data['brand'] == 'Roll Labels' && $data['printing'] != 'Y') {
            $finalPrice = array(
                'plainPrice' => $result['price'],
                'printPrice' => 0.00,
                'totalPrice' => ($result['price']));
            return $finalPrice;
        }
        // for Printed Sheeet
        if ($data['brand'] != 'Roll Labels' && $data['printing'] == 'Y') {
            // echo 'df';exit;
            if ($data['brand'] == 'A4 Labels') {
                $finalPrice = array(
                    'plainPrice' => $result['plainprice'],
                    //'printPrice'=>(($result['printprice'] + $result['designprice'] + $result['pressproof']) / 2 ),
                    'printPrice' => ($result['printprice'] + $result['designprice'] + $result['pressproof']),
                    'totalPrice' => ($result['plainprice'] + $result['pressproof'])
                );


            } else {
                $finalPrice = array(
                    'plainPrice' => $result['plainprice'],
                    'printPrice' => ($result['printprice'] + $result['designprice'] + $result['pressproof']),
                    'totalPrice' => ($result['plainprice'] + $result['designprice'] + $result['pressproof'])
                );
            }

            return $finalPrice;
        }
        // for plain sheet
        if ($data['brand'] != 'Roll Labels' && $data['printing'] != 'Y') {
            $finalPrice = array(
                'plainPrice' => $result['price'],
                'printPrice' => '0.00',
                'totalPrice' => $result['price']);
            return $finalPrice;
        } else {
            $finalPrice = array(
                'plainPrice' => (isset($result['plainprice']) && $result['plainprice'] > 0) ? $result['plainprice'] : '0.00',
                'printPrice' => '0.00',
                'totalPrice' => (isset($result['plainprice']) && $result['plainprice'] > 0) ? $result['plainprice'] : '0.00',
            );

            return $finalPrice;
        }


    }

    public function getWholeRecord($serialNo = null, $orderNumber, $manufactureId)
    {
        $results = $this->db->select("o.*,od.*,cat.*,p.ProductBrand,p.LabelsPerSheet")
            ->from('orders as o')
            ->join('orderdetails as od', 'o.OrderNumber = od.OrderNumber', 'left')
            ->join('products as p', 'od.ProductID = p.ProductID', 'left')
            ->join('category as cat', 'p.CategoryID = cat.CategoryID', 'left')
            ->where('o.OrderNumber', $orderNumber)
            ->where('od.SerialNumber', $serialNo)
            ->like('od.ManufactureID', $manufactureId)
            ->get()->row();
        return $results;
    }

    public function getNumberOfDesign($serialNumber)
    {
        $results = $this->db->select("count(*)as total")
            ->from('order_attachments_integrated as o')
            ->where('o.Serial', $serialNumber)
            ->get()->row();
        return $results->total;
    }

    public function getQuotationDetail($serial)
    {
        $results = $this->db->select("q.*")
            ->from('quotationdetails as q')
            ->where('q.SerialNumber', $serial)
            ->get()->row();
        return $results;
    }

    public function getCartDetail($cartId)
    {
        $results = $this->db->select("tp.*")
            ->from('temporaryshoppingbasket as tp')
            ->where('tp.ID', $cartId)
            ->get()->result();
        return $results[0];
    }

    public function getOrderDetail($serial)
    {
        $results = $this->db->select("q.*")
            ->from('orderdetails as q')
            ->where('q.SerialNumber', $serial)
            ->get()->row();
        return $results;
    }

    public function getBox($record)
    {

        $record = explode('(', $record);

        $res = 0;
        if (isset($record[1])) {
            if (strpos($record[1], '1000') !== false) {
                $res = 1000;
            } elseif (strpos($record[1], '250') !== false) {
                $res = 250;
            }
            return $res;
        } else {
            return 0;
        }

    }

}