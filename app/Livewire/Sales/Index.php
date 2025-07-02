<?php

namespace App\Livewire\Sales;

use App\Models\{Provider, Sale, ServiceType, Intermediary, Customer, Account};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\{Component, WithPagination};
use Livewire\Attributes\{Layout, Rule};

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap'; // أو 'tailwind' حسب التصميم المستخدم

    // حقول النموذج
    public ?string $beneficiary_name = null;
    #[Rule('required|date')]
    public string $sale_date;
    #[Rule('required|exists:service_types,id')]
    public int $service_type_id;
    #[Rule('nullable|exists:providers,id')]
    public ?int $provider_id = null;
    #[Rule('nullable|exists:intermediaries,id')]
    public ?int $intermediary_id = null;
    #[Rule('nullable|numeric')]
    public ?float $usd_buy = null;
    #[Rule('nullable|numeric')]
    public ?float $usd_sell = null;
    #[Rule('nullable|string')]
    public ?string $note = null;
    #[Rule('nullable|string')]
    public ?string $route = null;
    #[Rule('nullable|string')]
    public ?string $pnr = null;
    #[Rule('nullable|string')]
    public ?string $reference = null;
    #[Rule('nullable|string')]
    public ?string $action = null;
    #[Rule('nullable|numeric')]
    public ?float $amount_received = null;
    #[Rule('nullable|string')]
    public ?string $depositor_name = null;
    #[Rule('nullable|exists:accounts,id')]
    public ?int $account_id = null;
    #[Rule('nullable|exists:customers,id')]
    public ?int $customer_id = null;
    #[Rule('nullable|numeric')]
    public ?float $sale_profit = null;

    public ?Sale $editingSale = null;

    // حفظ البيانات
    public function save(): void
    {
        $this->validate();

        Sale::create($this->getSaleData());

        $this->resetForm();
        $this->dispatch('notify', message: 'تمت إضافة العملية بنجاح');
    }

    // نسخ عملية بيع
    public function duplicate(Sale $sale): void
    {
        $this->fill($sale->only([
            'beneficiary_name', 'sale_date', 'service_type_id', 'provider_id',
            'intermediary_id', 'usd_buy', 'usd_sell', 'note', 'route', 'pnr',
            'reference', 'action', 'amount_received', 'depositor_name',
            'account_id', 'customer_id', 'sale_profit'
        ]));
    }

    // إعادة تعيين النموذج
    public function resetForm(): void
    {
        $this->reset([
            'beneficiary_name', 'sale_date', 'service_type_id', 'provider_id',
            'intermediary_id', 'usd_buy', 'usd_sell', 'note', 'route', 'pnr',
            'reference', 'action', 'amount_received', 'depositor_name',
            'account_id', 'customer_id', 'sale_profit', 'editingSale'
        ]);
    }

    // الحصول على بيانات البيع
    protected function getSaleData(): array
    {
        return [
            'beneficiary_name' => $this->beneficiary_name,
            'sale_date' => $this->sale_date,
            'service_type_id' => $this->service_type_id,
            'provider_id' => $this->provider_id,
            'intermediary_id' => $this->intermediary_id,
            'usd_buy' => $this->usd_buy,
            'usd_sell' => $this->usd_sell,
            'note' => $this->note,
            'route' => $this->route,
            'pnr' => $this->pnr,
            'reference' => $this->reference,
            'action' => $this->action,
            'amount_received' => $this->amount_received,
            'depositor_name' => $this->depositor_name,
            'account_id' => $this->account_id,
            'customer_id' => $this->customer_id,
            'sale_profit' => $this->sale_profit,
            'user_id' => Auth::id(),
            'agency_id' => Auth::user()->agency_id,
        ];
    }

    #[Layout('layouts.agency')]
    public function render(): View
    {
        return view('livewire.sales.index', [
            'sales' => Sale::with([
                'user:id,name',
                'provider:id,name',
                'serviceType:id,name',
                'customer:id,name',
                'account:id,name'
            ])
            ->latest()
            ->paginate(10),

            'serviceTypes' => ServiceType::select('id', 'name')->get(),
            'providers' => Provider::select('id', 'name')->get(),
            'intermediaries' => Intermediary::select('id', 'name')->get(),
            'customers' => Customer::select('id', 'name')->get(),
            'accounts' => Account::select('id', 'name')->get(),
        ]);
    }
}
