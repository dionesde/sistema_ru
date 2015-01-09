<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
exec('ping -c1 200.132.200.3',$output,$res);
echo "<pre>".$res."</pre>";