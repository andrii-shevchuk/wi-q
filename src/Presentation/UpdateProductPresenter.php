<?php

namespace WiQ\Presentation;

use WiQ\Domain\Models\Product;

class UpdateProductPresenter
{
    /**
     * Render product as a CLI table
     */
    public function render(?Product $product): void
    {
        if (null === $product) {
            echo "No product found.\n";
            return;
        }

        // Determine column widths
        $idWidth = 2;    // minimum width for ID
        $nameWidth = 4;  // minimum width for Name


        $idWidth = max($idWidth, strlen((string)$product->id));
        $nameWidth = max($nameWidth, strlen($product->name));

        // Table separator
        $sep = '+'.str_repeat('-', $idWidth + 2).'+'.str_repeat('-', $nameWidth + 2).'+';

        // Header
        echo $sep . "\n";
        printf("| %-" . $idWidth . "s | %-" . $nameWidth . "s |\n", 'ID', 'Name');
        echo $sep . "\n";

        // Rows
        printf("| %-" . $idWidth . "s | %-" . $nameWidth . "s |\n", $product->id, $product->name);

        echo $sep . "\n";
    }
}
