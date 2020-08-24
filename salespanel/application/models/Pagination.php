<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pagination extends CI_Model
{
      function paginate_function($item_per_page, $current_page, $total_records, $total_pages){
         $next_pg = 1;
        if($current_page == 0 || $current_page==""){
            $next_pg = 2;
        }

        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
            $pagination .= '<ul class="pagination">';
            $right_links    = ($current_page + 11 ) ; 
            $previous       = $current_page - 1; //previous link
            $next           = $current_page + $next_pg; //next link
            $first_link     = true; //boolean var to decide our first link

            if($current_page > 1){
                $previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li id="li_page1" class="first"><a href="javascript:void(0);" data-page="1" title="First">&laquo;</a></li>'; //first link
                $pagination .= '<li><a href="javascript:void(0);" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
                for($i = ($current_page-2); $i < $current_page; $i++){
                    if($i > 0){
                        $pagination .= '<li><a href="javascript:void(0);" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                    }
                }
                $first_link = false;
            }

            if($first_link){
                $pagination .= '<li id="li_page1" class="first "><a href="javascript:void(0);" data-page="1" title="Page 1">1</a></li>';
            }

            elseif($current_page == $total_pages){
                $pagination .= '<li class="last active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
            }

            else{
                $pagination .= '<li class="active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
            }

            for($i = $current_page +$next_pg; $i < $right_links ; $i++){ //create right-hand side links

                if($i<=$total_pages){
                    $pagination .= '<li id="li_page'.$i.'"><a href="javascript:void(0);" data-page="'.$i.'" title="Page '.$i.'">'.$i .'</a></li>';
                }
            }
            
            
            
          
            if($current_page < $total_pages){
                $next_link = ($next < $total_pages)?$next:$total_pages;
                $pagination .= '<li><a href="javascript:void(0);" data-page="'.$next_link.'" title="Next">&gt;</a></li>';
                $pagination .= '<li class="last"><a href="javascript:void(0);" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>';
            }
            $pagination .= '</ul>';
        }
        return $pagination;
    }



}