<?php
$val = "true";
$bool = filter_var($val, FILTER_VALIDATE_BOOLEAN);
echo "Value: '$val'\n";
echo "Bool: " . ($bool ? 'TRUE' : 'FALSE') . "\n";
