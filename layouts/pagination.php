<?php

// Simple pagination script By Younes Mahmoud (:
$total_pages = (int)($product->allProducts / $record_per_page) ;

// echo  'all'.$product->countAll().'<br> per page'.$record_per_page.'<br>';
// echo $total_pages;
// if total pages real number so there should we add 1 to total page 
$total_pages  = is_real($total_pages)? $total_pages++:$total_pages;


$pre_2  = $page - 2 >= 1 ? $page - 2 : 0;
$pre_1  = $page - 1 >= 1 ? $page - 1 : 0;
$page  = $page;
$next_1 = $page + 1 <= $total_pages ? $page + 1 : 0;
$next_2 = $page + 2 <= $total_pages ? $page + 2 : 0;

$pre  = $pre_1;
$next = $next_1;

?>
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <?php 
    echo $pre != 0 ? '<li class="page-item"><a class="page-link"    href="'.$page_url.'page='.$pre.'">Previous</a></li>' : "" ;
    echo $pre_2 != 0 ? '<li class="page-item"><a class="page-link"  href="'.$page_url.'page='.$pre_2.'">'.$pre_2.'</a></li>' : "" ;
    echo $pre_1 != 0 ? '<li class="page-item"><a class="page-link"  href="'.$page_url.'page='.$pre_1.'">'.$pre_1.'</a></li>':''; 
    echo '    <li class="page-item active"><a class="page-link"     href="'.$page_url.'page='.$page.'">'. $page.'</a></li>';
    echo $next_1 != 0 ? '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$next_1.'">'.$next_1.'</a></li>' : "" ;
    echo $next_2 != 0 ? '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$next_2.'">'.$next_2.'</a></li>':'';
    echo $next != 0 ? '<li class="page-item"><a class="page-link"   href="'.$page_url.'page='.$next.'">Next</a></li>':''; 
    ?>    

  </ul>
</nav>







<?php





// echo $total_pages;
// $display =3;
// // $next_page = $page < $total_pages ? $page ++ :0;
// // $pre_page = $page > 1 ? $page -- : 0;

// $total_pages= 20;
// for ($page0 = 1; $page0 <= $total_pages ; $page0++) { 


// $pre_2  = $page0 - 2 >= 1 ? $page0 - 2 : 0;
// $pre_1  = $page0 - 1 >= 1 ? $page0 - 1 : 0;
// $page0  = $page0;
// $next_1 = $page0 + 1 <= $total_pages  ? $page0 + 1:0;
// $next_2 = $page0 + 2 <= $total_pages ? $page0 + 2 :0;


// echo "
// pre_2  ={$pre_2 }<br>
// pre_1  ={$pre_1 }<br>
// page   ={$page  }<br>
// next_1 ={$next_1}<br>
// next_2 ={$next_2}<br>
// pre  ={$pre }<br>
// next ={$next}<br>

// ========================================<br>" ;

// }