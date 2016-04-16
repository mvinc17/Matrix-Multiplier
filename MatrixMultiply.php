<?php

$n = 4; 									//Enter the number of iterations here.

$t = array(									//This is the transition matrix
	array(0.4 ,0.2 ,0   ,0.2 ,0    ,0),
	array(0.3 ,0.4 ,0.2 ,0   ,0.12 ,0),
	array(0   ,0.2 ,0.4 ,0   ,0    ,0.3),
	array(0.3 ,0   ,0   ,0.4 ,0.24 ,0),
	array(0   ,0.2 ,0   ,0.4 ,0.4  ,0.3),
	array(0   ,0   ,0.4 ,0   ,0.24 ,0.4)
);

$s = array(									//This is the initial state matrix
	array(1),
	array(0),
	array(0),
	array(0),
	array(0),
	array(0)
);


/* NOTHING BELOW THIS LINE NEEDS TO BE CHANGED TO PERFORM DIFFERENT CALCULATIONS */



function M_mult($_A,$_B) {
  // AxB outcome is C with A's rows and B'c cols
  $r = count($_A);
  $c = count($_B[0]);
  $in= count($_B); // or $_A[0]. $in is 'inner' count

  if ( $in != count($_A[0]) ) {
    print("ERROR: need to have inner size of matrices match.\n");
    print("     : trying to multiply a ".count($_A)."x".count($_A[0])." by a ".count($_B)."x".count($_B[0])." matrix.\n");
    print("\n");
    exit(1);
  }

  // allocate retval
  $retval = array();
  for($i=0;$i< $r; $i++) { $retval[$i] = array(); }
    // multiplication here
    for($ri=0;$ri<$r;$ri++) {
      for($ci=0;$ci<$c;$ci++) {
        $retval[$ri][$ci] = 0.0;
        for($j=0;$j<$in;$j++) {
          $retval[$ri][$ci] += $_A[$ri][$j] * $_B[$j][$ci];
        }
      }
    }
    return $retval;
  }




$current = 1;
function calculate($no) {
	global $s, $t, $current;
	$result = M_mult($t, $s);

	for($i = 1; $i <= ($no - 1); $i++) {
		if(floor(($i / $no) * 100) != $current) {
			echo "-";
			$current = floor(($i / $no) * 100);
		}
		$result = M_mult($t, $result);
	}
	
	return $result;
}





echo PHP_EOL;

// for($i = 10; $i < 1000; $i++) {
// 	$result = calculate($i);
// 	if($result == calculate($i - 1)) {
// 		echo "FOUND LIMIT AT ".$i.PHP_EOL;
// 		die();
// 	}
// }


$result = calculate($n);

echo PHP_EOL;

foreach($result as $row) {
	foreach($row as $value) {
		echo str_pad(round($value, 10), 12)."  ";
	}
	echo PHP_EOL;
}


?>