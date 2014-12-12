<?php
$q = intval($_GET['q']);
$t = intval($_GET['t']);

$conn = oci_connect('teamatest1', 'teama123', 'oralinux.seas.gwu.edu/team1');
if (!$conn) {
  echo "Connecting Failed!";
}
else {
  $s_table = array('property', 'buyer', 'seller', 'sales_agent', 'branch_office');
  $s_opra = array('Search', 'Add', 'Delete', 'Modify');

  if ($q == 3 || $q == 4) {
    $stid = oci_parse($conn, 'SELECT * FROM ' . $s_table[$t - 1]);
    oci_execute($stid);
    echo '<select id="RetSelect"> <option value="">Select an ID</option>';
    $lcount = 0;
    $fcid = "";
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
      if ($lcount == 0) {
        $r_keys = array_keys($row);
        $fcid = $r_keys[0];
      }
      $lcount++;
      echo '<option value="' . $row[$fcid] . '">' . $row[$fcid] . '</option>'; 
    }
    echo '</select>';
  }

  if ($q == 1 || $q == 2 || $q == 4) {
    $stid = oci_parse($conn, 'SELECT * FROM ' . $s_table[$t - 1]);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $r_keys = array_keys($row);
    echo '<table class="reference notranslate">';
    echo '<tr> <th> Column Count </th> <th>' . 
    '<input id="RetNumber" type="text" value="' . sizeof($row) . 
    '" readonly> </th> </tr>'; 
    foreach ($r_keys as $item) {
      echo '<tr> <td>' . $item . '</td>';
      echo '<td> <input name = "RetValues" type="text"> </td> </tr>';
    }
    echo "</table>";
  }
  //  echo $s_opra[$q - 1] . ' Not Available!';
}
?>

