<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('enquiry/EnquiryModal');
        $this->home_model->user_login_ajax();
        error_reporting(E_ALL);
    }


//------------------------------------------------STAR OF FILE----------------------------------------------------------	   
    public function index()
    {

        $data['main_content'] = "enquiry/enquiry";
        $this->load->view('page', $data);
    }

    public function getAllEnquires()
    {
        $enquries = $this->EnquiryModal->getAllEnquires();
        echo $enquries->generate();
    }

    public function addEnquiry()
    {
        $data['eqno'] = $this->EnquiryModal->getQuoteNum();
        $data['main_content'] = 'enquiry/enquiry_insert';
        $this->load->view('page', $data);

    }

    public function insertEnquiry()
    {
        $values = $_POST;
        $values['category'] = $this->convertTempCat($values['category']);
        $this->EnquiryModal->insertEnquires($values);
        $this->index();
    }

    public function getEnquiryDetail($quoteNumber)
    {
        $data['EnquiryDetail'] = $this->EnquiryModal->getEnquiryDetail($quoteNumber)[0];


        $data['materials'] = $this->EnquiryModal->getMaterial($this->convertReal($data['EnquiryDetail']->category), $data['EnquiryDetail']->Shape);


        $data['shapes'] = $this->EnquiryModal->getShapes($this->convertReal($data['EnquiryDetail']->category));
        $data['main_content'] = 'enquiry/enquiry_detail';
        $this->load->view('page', $data);
    }

    public function getShape()
    {
        echo json_encode(array('shapes' => $this->EnquiryModal->getShapes($this->input->get('catt_type'))));
    }

    public function getMaterial()
    {
        echo json_encode(array('materials' => $this->EnquiryModal->getMaterial($this->input->get('cat'), $this->input->get('shape'))));
    }


    public function updateEnquiry()
    {
        $values = $this->input->post();
        //$values['category'] = $this->convertTempCat($values['category']);
        if(@$values['operatorNotes']){
            $this->EnquiryModal->updateEnquiryNotes($values);
        }else{
            $this->EnquiryModal->updateEnquiry($values);
        }
        return $this->getEnquiryDetail($values['enquiry_number']);
    }
    public function convertReal($val)
    {
        if ($val == 'Labels on A4 Sheet') {
            return 'A4 Labels';
        } elseif ($val == 'Labels on A3 Sheet') {
            return 'A3 Label';
        } elseif ($val == 'Labels on SRA3 Sheets') {
            return 'SRA3 Label';
        } elseif ($val == 'Integrated') {
            return 'Integrated Labels';
        } elseif ($val == 'Labels on Roll') {
            return 'Roll Labels';
        }
    }

    public function convertTempCat($val)
    {

        if ($val == 'A4 Labels') {
            return 'Labels on A4 Sheet';
        } elseif ($val == 'A3 Label') {
            return 'Labels on A3 Sheet';
        } elseif ($val == 'SRA3 Label') {
            return 'Labels on SRA3 Sheets';
        } elseif ($val == 'Integrated Labels') {
            return 'Integrated';
        } elseif ($val == 'Roll Labels') {
            return 'Labels on Roll';
        }
    }

    public function convertShape($records)
    {
        $final = array();
        foreach ($records as $record) {
            if ($record->Shape_upd == 'Circular') {
                $record->Shape_upd = 'Circle';
                $final[] = $record;
            } else {
                $final[] = $record;
            }
        }
        return $final;
    }


    public function ChangeStatus()
    {
        $qno = $this->input->post('QuoteNumber');
        $rqs = $this->input->post('RequestStatus');

        $status = $this->EnquiryModal->ChangeStatus($qno, $rqs);

        ################################### Talal ###################################
        if ($rqs == 11) {
            $stat = "Required Action";
        } else if ($rqs == 12) {
            $stat = "Awaiting Reply";
        } else {
            $stat = "Completed";
        }

        $UserName = $this->session->userdata("UserName");
        $this->db->insert("callback_comment", array("OrderNumber" => $qno, "Operator" => $this->session->userdata("UserID"), "comment" => $UserName . " set " . $stat, "Time" => time()));
        ################################### Talal ###################################

        echo json_encode($status);

    }

}
