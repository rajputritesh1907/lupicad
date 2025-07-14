<?php 
function  get_safe_value($str){
    $str = trim($str);
    $str = htmlspecialchars($str);
    $str = addslashes($str);
}
 function addToCart($int){
    echo "<script>console.log('hlo')<script>";
 }

?>
