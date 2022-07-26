<?php

namespace App\Http\Controllers;
use QrCode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
      return QrCode::size(300)->generate(url('admin/events'));
    }
}
