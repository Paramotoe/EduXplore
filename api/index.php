";
    echo "💥 LARAVEL CRASH ON BOOT:";
    echo "Pesan Error: " . htmlspecialchars($e->getMessage()) . "";
    echo "File: " . htmlspecialchars($e->getFile()) . " (Baris " . $e->getLine() . ")";
    echo "";
}