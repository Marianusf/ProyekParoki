<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPeminjamanStatus extends Mailable
{
    use Queueable, SerializesModels;
    public $status;
    public $alasan;
    public $peminjamName;
    public $assetDetails;

    public function __construct($status, $alasan, $peminjamName, $assetDetails)
    {
        $this->status = $status;
        $this->alasan = $alasan;
        $this->peminjamName = $peminjamName;
        $this->assetDetails = $assetDetails;
    }

    public function build()
    {
        return $this->subject('Status Peminjaman')
            ->view('emails.PeminjamanStatus')
            ->with([
                'status' => $this->status,
                'alasan' => $this->alasan,
                'peminjamName' => $this->peminjamName,
                'assetDetails' => $this->assetDetails,
            ]);
    }
}
