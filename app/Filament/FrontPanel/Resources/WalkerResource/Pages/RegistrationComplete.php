<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use App\Invoice\Facades\QrCodeGenerator;
use App\Invoice\Invoice;

use App\Mail\InvoicePaid;
use App\Mail\RegistrationCompleted;
use App\Models\Walker;
use App\Utils\FileUtils;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

class RegistrationComplete extends Page
{
    use InteractsWithRecord;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $resource = WalkerResource::class;
    public ?string $qrCode;
    public ?string $qrCodeScanning;
    public ?string $registrationEndDate = null;

    public function getView(): string
    {
        return 'filament.front-panel.resources.registration-resource.pages.registration-complete';
    }

    public function mount(int|string $record): void
    {
        /**
         * @var Walker $this ->record
         */
        $this->record = $this->resolveRecord($record);

        $qrCodePath = QrCodeGenerator::make()
            ->id($this->record->id)
            ->qrCodePath();

        if ($qrCodePath) {
            $this->qrCode = FileUtils::convertToBase64($qrCodePath);
        }
        $fileScanning = public_path('images/qr-code-scanning2.jpg');
        $this->qrCodeScanning = FileUtils::convertToBase64($fileScanning);
        $this->registrationEndDate = Carbon::parse(config('invoices.TRAIL_TSHIRT_ENDDATE'))->translatedFormat('j F Y');

        $walker = $this->record;
/*        try {
            Mail::to(new Address($walker->email, $walker->email))
                ->send(new RegistrationCompleted($walker));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }*/

    }

    public function getTitle(): string|Htmlable
    {
        return __('invoices::messages.form.registration.actions.edit.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label(__('invoices::messages.invoice.payment.pdf.link.label'))
                ->icon('tabler-file-type-pdf')
                ->action(function (Walker $record) {
                    $invoicePath = Invoice::make()
                        ->walker($record)
                        ->invoicePath();

                    return Invoice::downloadPdfFromPath($invoicePath);
                }),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }
}
