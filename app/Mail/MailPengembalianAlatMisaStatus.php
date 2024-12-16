<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPengembalianAlatMisaStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $alasan;
    public $peminjamName;
    public $alatMisaDetails;

    /**
     * Buat instance baru untuk email.
     *
     * @param string $status - Status pengembalian ('approved' atau 'rejected')
     * @param string|null $alasan - Alasan penolakan (jika ada)
     * @param string $peminjamName - Nama peminjam
     * @param array $alatMisaDetails - Detail alat misa (nama alat dan jumlah)
     */
    public function __construct($status, $alasan, $peminjamName, $alatMisaDetails)
    {
        $this->status = $status;
        $this->alasan = $alasan;
        $this->peminjamName = $peminjamName;
        $this->alatMisaDetails = $alatMisaDetails;
    }

    /**
     * Build the email message.
     *
     * @return $this
     */
    public function build()
    {
        // Ubah subjek email berdasarkan status pengembalian
        $subject = $this->status === 'approved'
            ? 'Pengembalian Alat Misa Anda Disetujui'
            : 'Pengembalian Alat Misa Anda Ditolak';

        return $this->subject($subject)
            ->view('emails.pengembalianAlatMisaStatus')
            ->with([
                'status' => $this->status,
                'alasan' => $this->alasan,
                'peminjamName' => $this->peminjamName,
                'alatMisaDetails' => $this->alatMisaDetails,
            ]);
    }
}
