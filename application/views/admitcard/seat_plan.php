<!DOCTYPE html>
<html>
<head>
    <style>
        @media print {
            .page-break {
                page-break-after: always;
            }
        }
       
        table.outer-table {
    width: 100%;
    border-spacing: 20px 30px; /* Adds horizontal spacing between columns and vertical between rows */
}

        td.sticker-cell {
            width: 50%;
            padding: 10px;
            border: 1px solid #000;
            vertical-align: top;
            height: 110px;
        }
        table.sticker-table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        .sticker-header {
            text-align: center;
            font-size: 13px;
            padding: 5px 0;
        }
        .logo {
            width: 60px;
        }
        .logo img {
            height: 60px;
        }
        .photo {
            width: 60px;
            height: 70px;
            border: 1px solid #000;
            object-fit: cover;
        }
        .photo-empty {
            width: 60px;
            height: 70px;
            border: 1px solid #000;
        }
       
    </style>
</head>
<body>

<?php
 

    if($semester_id==1)
    {
        $semester_id="1st";
    }
    elseif($semester_id==2)
    {
        $semester_id="2nd";
    }
    else{$semester_id="3rd";}

$counter = 0;
$total = count($students);

while ($counter < $total):
    echo '<table class="outer-table">';
    for ($i = 0; $i < 5 && $counter < $total; $i++): // 4 rows
        echo '<tr>';
        for ($j = 0; $j < 2 && $counter < $total; $j++): // 2 columns
            $std = $students[$counter];
?>

    <td class="sticker-cell">
        <table class="sticker-table">
            <tr>
                <td class="logo"><img src="<?= base_url('assets/logo/jagannath-university-logo-vector.png') ?>" alt="Logo"></td>
                <td class="sticker-header">
                    <strong>Jagannath University</strong><br>
                   <strong>M.Sc. in CSE (Professional) </strong>  

                    <br><?= $batch->session?>&nbsp;(<?= $batch->batch_name?>)<br>

                    <?= $semester_id ?> Sems. <?= $exam_type ?> - <strong><?= $exam_year ?></strong></strong></p>
                    <br>
                    <br>
                    
                    
                </td>
               
                <td style="text-align: right;">
                    <?php if (!empty($std->image)): ?>
                        <img src="<?= base_url('uploads/students/'.$std->image) ?>" class="photo" alt="Photo">
                    <?php else: ?>
                        <div class="photo-empty"></div>
                    <?php endif; ?>
                </td>
            </tr>
           
            <tr class="bottom"style="text-align:center; border: 1px solid #000;">
                    <td colspan="3">Name: &nbsp;<strong><?= strtoupper($std->name) ?></strong><br>
    Student ID: &nbsp;<strong><?= $std->std_id ?></strong></td>

    </tr>
           
          
        </table>
    </td>
<?php
            $counter++;
        endfor;
        // Fill empty column if odd number
        if ($j == 1 && $counter >= $total) echo '<td class="sticker-cell"></td>';
        echo '</tr>';
    endfor;
    echo '</table><div class="page-break"></div>';
endwhile;
?>

</body>
</html>
