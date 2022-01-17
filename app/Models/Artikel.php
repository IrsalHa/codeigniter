<?php


namespace App\Models;

use CodeIgniter\Model;

class Artikel extends Model
{
    protected $table = 'articles';
    protected $allowedFields = ['judul_artikel', 'isi_artikel', 'thumbnail_artikel', 'tag_artikel', 'kategori_artikel'];
}