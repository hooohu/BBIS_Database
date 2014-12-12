<?php
$q = intval($_GET['q']);
$t = intval($_GET['t']);
$d = '';
if ($q == 3 || $q == 4) $d = urldecode($_GET['d']);
$n = 0;
$v = array();
if ($q != 3) {
  $n = intval($_GET['n']);
  for ($i = 0; $i < $n; $i++) {
    array_push($v, urldecode($_GET['v' . $i]));
  }
}

$conn = oci_connect('teamatest1', 'teama123', 'oralinux.seas.gwu.edu/team1');
if (!$conn) {
  echo "Connecting Failed!";
}
else {
  $s_table = array('property', 'buyer', 'seller', 'sales_agent', 'branch_office');
  $s_opra = array('Search', 'Add', 'Delete', 'Modify');
  if ($q == 1) {
    $sql_query = 'SELECT * FROM ' . $s_table[$t - 1];
    $stid = oci_parse($conn, $sql_query);
    oci_execute($stid);
    echo '<table class="reference notranslate">';
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $r_keys = array_keys($row);
    echo '<tr>';
    foreach ($r_keys as $i) {
      echo '<th>' . $i . '</th>';
    } 
    echo '</tr>';
    $where = ' WHERE ';
    for($i = 0; $i < $n; $i++) {
      if ($v[$i] != '') {
        if ($where != ' WHERE ') $where .= ' AND ';
        $where .= ($r_keys[$i] . ' = \'' . $v[$i]) . '\'';
      }
    }
    if ($where != ' WHERE ') $sql_query .= $where;
    $stid = oci_parse($conn, $sql_query);
    oci_execute($stid);
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
      echo '<tr>';
      foreach ($row as $i) {
        echo '<td>' . $i . '</td>';
      }
      echo '</tr>';
    } 
    echo '</table>';
  }
  else if ($q == 2) {
    $ins_query = 'INSERT INTO ' . $s_table[$t - 1] . ' VALUES('
      . $s_table[$t - 1] . '_ID_seq.NEXTVAL ';
    for ($i = 1; $i < $n; $i++) {
      $ins_query .= ' , ';
      if ($v[$i] == '') {
        $ins_query .= ' null ';
      }
      else $ins_query .= '\'' . $v[$i] . '\'';
    }
    $ins_query .= ')';
    echo $ins_query;
    $stid = oci_parse($conn, $ins_query);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
      echo "Insert Error!";
      return;
    }
    $r = oci_commit($conn); 
    if ($r) echo ' Successfully Added! ';
  }
  else if ($q == 3) {
    $sql_query = 'SELECT * FROM ' . $s_table[$t - 1];
    $stid = oci_parse($conn, $sql_query);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $r_keys = array_keys($row);
    $del_query = 'DELETE FROM ' . $s_table[$t - 1] . ' WHERE ' . 
      $r_keys[0] . ' = \'' . $d . '\'';
    echo $del_query;
    $stid = oci_parse($conn, $del_query);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
      echo "Delete Error!";
      return;
    }
    $r = oci_commit($conn);
    if ($r) echo ' Successfully Deleted! ';
  }
  else if ($q == 4) {
    $sql_query = 'SELECT * FROM ' . $s_table[$t - 1];
    $stid = oci_parse($conn, $sql_query);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    $r_keys = array_keys($row);
    $upt_query = 'UPDATE ' . $s_table[$t - 1] . ' SET ';
    for ($i = 1; $i < $n; $i++) {
      if ($i > 1) $upt_query .= ',';
      $upt_query .= $r_keys[$i] . '=\'' . $v[$i] . '\'';
    }
    $upt_query .= ' WHERE ' . $r_keys[0] . ' = \'' .$d . '\'';
    echo $upt_query;
    $stid = oci_parse($conn, $upt_query);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
      echo "Modify Error!";
      return;
    }
    $r = oci_commit($conn);
    echo ' Successfully Modified! ';
  }
}
  
?>

