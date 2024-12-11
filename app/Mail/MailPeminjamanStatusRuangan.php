<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class MailPeminjamanStatusRuangan extends Mailable
{
    public $status;
    public $peminjamName;
    public $alasan;
    public $ruanganDetails;

    public function __construct($status, $peminjamName, $alasan, $ruanganDetails)
    {
        $this->status = $status;
        $this->peminjamName = $peminjamName;
        $this->alasan = $alasan;
        $this->ruanganDetails = $ruanganDetails;
    }

    public function build()
    {
        return $this->subject('Status Peminjaman Ruangan Anda')
            ->view('emails.MailPeminjamanStatusRuangan');
    }
}
