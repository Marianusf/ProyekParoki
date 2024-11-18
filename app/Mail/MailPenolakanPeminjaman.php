<?

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPenolakanPeminjaman extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Peminjaman Ditolak')
            ->view('emails.penolakan-peminjaman'); // Nama view email
    }
}
