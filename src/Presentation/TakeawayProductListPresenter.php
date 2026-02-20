<?php

namespace WiQ\Presentation;

use WiQ\Domain\Models\Product;

class TakeawayProductListPresenter
{
    /**
     * Render products as a CLI table
     *
     * @param Product[] $products
     */
    public function render(array $products): void
    {
        if (empty($products)) {
            echo "No products found.\n";
            return;
        }

        // Determine column widths
        $idWidth = 2;    // minimum width for ID
        $nameWidth = 4;  // minimum width for Name

        foreach ($products as $p) {
            $idWidth = max($idWidth, strlen((string)$p->id));
            $nameWidth = max($nameWidth, strlen($p->name));
        }

        // Table separator
        $sep = '+'.str_repeat('-', $idWidth + 2).'+'.str_repeat('-', $nameWidth + 2).'+';

        // Header
        echo $sep . "\n";
        printf("| %-" . $idWidth . "s | %-" . $nameWidth . "s |\n", 'ID', 'Name');
        echo $sep . "\n";

        // Rows
        foreach ($products as $p) {
            printf("| %-" . $idWidth . "s | %-" . $nameWidth . "s |\n", $p->id, $p->name);
        }

        echo $sep . "\n";
    }
}
