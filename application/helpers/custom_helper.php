<?php
function number_to_words($number)
{
    $words = array(
        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three',
        4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven',
        8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven',
        12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
        15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
        18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
        30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
        60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty',
        90 => 'Ninety'
    );

    if ($number < 21) return $words[$number];
    elseif ($number < 100)
        return $words[10 * floor($number / 10)] . ($number % 10 ? ' ' . $words[$number % 10] : '');
    elseif ($number < 1000)
        return $words[floor($number / 100)] . ' Hundred' . ($number % 100 ? ' and ' . number_to_words($number % 100) : '');
    elseif ($number < 100000)
        return number_to_words(floor($number / 1000)) . ' Thousand' . ($number % 1000 ? ' ' . number_to_words($number % 1000) : '');
    elseif ($number < 10000000)
        return number_to_words(floor($number / 100000)) . ' Lakh' . ($number % 100000 ? ' ' . number_to_words($number % 100000) : '');
    else
        return number_to_words(floor($number / 10000000)) . ' Crore' . ($number % 10000000 ? ' ' . number_to_words($number % 10000000) : '');
}


