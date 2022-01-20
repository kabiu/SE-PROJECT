<?php

array_to_csv_download(
	array(
		array(
			"Product Name",
			"Category",
			"Purchase Price",
			"Sale Price",
			"Initial Stock",
			"Units of Measure"
		)
	)
);

function array_to_csv_download($array) {
    $filename = "SampleProducts.csv";
    $delimiter=",";
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}



?>