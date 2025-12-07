<?php
// Quick script to find all header view calls that need updating in Admin controller
// Run this to see which lines need to be updated

$file = 'c:\xampp\htdocs\erp\application\controllers\admin\Admin.php';
$content = file_get_contents($file);
$lines = explode("\n", $content);

echo "Header view calls that need updating:\n\n";

foreach ($lines as $lineNum => $line) {
    if (strpos($line, 'load->view("common/header")') !== false && 
        strpos($line, '$this->header') === false) {
        echo "Line " . ($lineNum + 1) . ": " . trim($line) . "\n";
        echo "Should be: \t\$this->load->view(\"common/header\", \$this->header);\n\n";
    }
}

echo "Run this in your text editor to replace all:\n";
echo "Find: \$this->load->view(\"common/header\");\n";
echo "Replace: \$this->load->view(\"common/header\", \$this->header);\n";
?>