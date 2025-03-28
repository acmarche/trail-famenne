<?php

namespace App\Invoice\Traits;

use App\Invoice\Buyer;

use App\Models\Walker;
use Exception;
use Symfony\Component\HttpFoundation\File\File;

trait InvoiceHelpers
{
    public string $id;

    public function walker(Walker $walker): static
    {
        $this->walker = $walker;
        $this->id = $this->walker->id;

        return $this;
    }

    public function notes(string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function logo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function buyer(Buyer $buyer): static
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function template(string $template = 'default'): static
    {
        $this->template = $template;

        return $this;
    }

    public function filename(string $filename): static
    {
        $this->filename = sprintf('%s.pdf', $filename);

        return $this;
    }

    public function getLogo(): string
    {
        $file = new File($this->logo);

        return 'data:'.$file->getMimeType().';base64,'.base64_encode($file->getContent());
    }

    /**
     * @throws Exception
     */
    protected function beforeRender(): void
    {
        $this->validate();
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        if (!$this->walker) {
            throw new Exception('Walker not defined.');
        }
    }

}
