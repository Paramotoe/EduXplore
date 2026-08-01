';
    echo '💥 ERROR ASLI TERDETEKSI:';
    echo 'Penyebab: ' . htmlspecialchars($e->getMessage()) . '';
    echo 'File: ' . htmlspecialchars($e->getFile()) . ' (Baris ' . $e->getLine() . ')';
    echo '';
}