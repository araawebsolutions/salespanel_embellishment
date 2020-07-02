<?php

$controller = $this->router->fetch_class();
$method = $this->router->fetch_method();


$this->load->view('order_quotation/label_embellishment_print_service/header');
$this->load->view($main_content);
$this->load->view('order_quotation/label_embellishment_print_service/footer');

?>



