';
    echo '💥 ERROR ASLI TERDETEKSI:';
    echo 'Penyebab (Class): ' . get_class($e) . '';
    echo 'Pesan Error: ' . $e->getMessage() . '';
    echo 'File: ' . $e->getFile() . ' (Baris ' . $e->getLine() . ')';
    echo '';
    exit(1);
}