<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTerimaPendaftaran extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjam;

    public function __construct($peminjam)
    {
        $this->peminjam = $peminjam;
    }

    public function build()
    {
        return $this->subject('Akun Anda telah Disetujui')
            ->view('emails.PenerimaanAkun')
            ->with([
                'name' => $this->peminjam->name,
                'email' => $this->peminjam->email,
            ]);
    }
}
