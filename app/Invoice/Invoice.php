<?php

namespace App\Invoice;

use App\Invoice\QrCode\QrCodeGenerator;
use App\Invoice\Traits\InvoiceHelpers;
use App\Invoice\Traits\PdfHelper;
use App\Invoice\Traits\SavesFiles;

use App\Models\Walker;
use Carbon\Carbon;
use Carbon\CarbonInterface;

//todo test https://github.com/ElegantEngineeringTech/laravel-invoices/blob/main/resources/views/default/style.blade.php
class Invoice
{
    use SavesFiles;
    use PdfHelper;
    use InvoiceHelpers;

    public int $table_columns = 4;

    public ?string $name;

    public ?string $logo;

    public Buyer $buyer;

    public Walker $walker;

    public array $paperOptions;

    /**
     * @see \Dompdf\Options
     */
    public array $options;

    public ?string $notes = null;

    public CarbonInterface|Carbon $date;

    /**
     * Invoice constructor.
     *
     * @param string $name
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $name = '')
    {
        // Invoice
        $this->name = $name ?: __('invoices::invoice.invoice');
        $this->template = 'invoice';

        // Paper
        $this->paperOptions = config('invoices.paper');

        // DomPDF options
        /**
         * @see \Dompdf\Options
         */
        $this->options = array_merge(
            app('dompdf.options'),
            config('invoices.dompdf_options') ?? ['enable_php' => true, 'enable_remote' => true],
        );

        $this->disk = 'invoices';
    }

    /**
     * @param Walker $walker
     * @return void
     * @throws \Exception
     */
    public static function generateWithQrCode(Walker $walker):void
    {
        try {
            QrCodeGenerator::generateAndSaveIt($walker);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        try {
            self::generatePdfAndSaveIt($walker);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $name
     *
     * @return Invoice
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     */
    public static function make($name = '')
    {
        return new static($name);
    }

}
