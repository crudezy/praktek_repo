<?php
 
// fungsi untuk mengembalikan format rupiah dari suatu nominal tertentu
// dengan pemisah ribuan 
function rupiah($nominal) {
    return "Rp " . number_format($nominal, 3);

}

function dolar($nominal) {
    return "USD ".number_format($nominal);
}