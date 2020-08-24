<?php

$controller = $this->router->fetch_class();
$method = $this->router->fetch_method();


$this->load->view('includes/header');
$this->load->view($main_content);
$this->load->view('includes/footer');

?>



