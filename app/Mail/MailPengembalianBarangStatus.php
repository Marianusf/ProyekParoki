<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPengembalianBarangStatus extends Mailable
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
        return $this->subject('Status Pengembalian')
            ->view('emails.PengembalianBarangStatus')
            ->with([
                'status' => $this->status,
                'alasan' => $this->alasan,
                'peminjamName' => $this->peminjamName,
                'assetDetails' => $this->assetDetails,
            ]);
    }
}
