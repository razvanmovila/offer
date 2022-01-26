<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

class InvoiceController extends Controller
{

    public function show()
    {
        $client = new Party([
            'name'          => 'Jolie Albert',

        ]);

        $customer = new Party([
            'name'          => 'Lillith Hooper',

        ]);

        $items = [
            (new InvoiceItem())
                ->title('Offer 1')

                ->pricePerUnit(47.79)
                ->quantity(2)
                ->discount(10),
            (new InvoiceItem())->title('Offer 2')->pricePerUnit(120)->quantity(1),
            (new InvoiceItem())->title('Offer 3')->pricePerUnit(120),
            (new InvoiceItem())->title('Offer 4')->pricePerUnit(746)->quantity(1)->discount(4)->units('XL'),
            (new InvoiceItem())->title('Offer 5')->pricePerUnit(166)->quantity(1)->discountByPercent(9),
            (new InvoiceItem())->title('Offer 6')->pricePerUnit(861)->quantity(1),
            (new InvoiceItem())->title('Offer 7')->pricePerUnit(212)->quantity(1)->discount(3),
            (new InvoiceItem())->title('Offer 8')->pricePerUnit(10990)->quantity(1)->discountByPercent(3)->units('XXS'),
            (new InvoiceItem())->title('Offer 9')->pricePerUnit(355)->quantity(1)->units('L'),


        ];

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Invoice')
            ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid

            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();

    }

}
