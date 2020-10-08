<?php
include_once('index.php');
 function isConnected($mybool) {
    if (!$mybool) {
      throw new MyAssertionException('Not connected to the db check credentials!');
    }
    return true;
  }
  isConnected(dbConnect());

  ?>