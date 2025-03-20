<?php

namespace App\Filament\Actions;

use App\Invoice\Invoice;

use App\Models\Walker;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class InvoiceDownloadAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'invoiceDownload';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Facture')
            ->icon('tabler-file-type-pdf')
            ->color('info')
            ->action(function (Walker $walker) {
                $invoicePath = Invoice::make()
                    ->walker($walker)
                    ->invoicePath();
                if (!$invoicePath) {
                    try {
                        Invoice::generateWithQrCode($walker);
                        $invoicePath = Invoice::make()
                            ->walker($walker)
                            ->invoicePath();
                    } catch (\Exception $exception) {
                        Notification::make()
                            ->danger()
                            ->title(__('Error : ').$exception->getMessage())
                            ->send();
                        $this->halt();
                    }
                }

                return Invoice::downloadPdfFromPath($invoicePath);
            });
    }
}
