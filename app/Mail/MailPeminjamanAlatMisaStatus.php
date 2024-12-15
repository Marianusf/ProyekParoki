<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPeminjamanAlatMisaStatus extends Mailable
{
    use Queueable, SerializesModels;
    public $status;
    public $alasan;
    public $peminjamName;
    public $alatmisa;

    public function __construct($status, $alasan, $peminjamName, $alatmisa)
    {
        $this->status = $status;
        $this->alasan = $alasan;
        $this->peminjamName = $peminjamName;
        $this->alatmisa = $alatmisa;
    }

    public function build()
    {
        return $this->subject('Status Peminjaman')
            ->view('emails.PeminjamanAlatMisaStatus')
            ->with([
                'status' => $this->status,
                'alasan' => $this->alasan,
                'peminjamName' => $this->peminjamName,
                'alatmisa' => $this->alatmisa,
            ]);
    }
}
