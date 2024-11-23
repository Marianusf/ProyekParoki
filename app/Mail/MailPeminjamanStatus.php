<?

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPeminjamanStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $alasan;
    public $name;
    public $assetName; // Add the asset name to the mail class

    // Modify constructor to accept the asset name
    public function __construct($status, $alasan, $name, $assetName)
    {
        $this->status = $status;
        $this->alasan = $alasan;
        $this->name = $name;
        $this->assetName = $assetName; // Assign asset name
    }

    // Build the email message
    public function build()
    {
        return $this->view('emails.PeminjamanStatus') // Ensure correct path for view
            ->with([
                'status' => $this->status,
                'alasan' => $this->alasan,
                'name' => $this->name,
                'assetName' => $this->assetName, // Pass asset name to the view
            ])
            ->subject($this->status == 'disetujui' ? 'Peminjaman Disetujui' : 'Peminjaman Ditolak');
    }
}
