<div class="space-y-6">
    <!-- نموذج الإضافة -->
    <div class="bg-white rounded-xl shadow-md p-4">
        <h2 class="text-xl font-bold text-emerald-700 mb-4 text-center">إضافة عملية بيع</h2>

        <form wire:submit.prevent="save" class="space-y-4 text-sm">
            @php
                $fieldClass = 'w-full rounded-lg border border-gray-300 px-3 py-1 focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white text-xs';
                $labelClass = 'block mb-1 text-gray-700 font-semibold text-xs';
            @endphp

            <!-- الصف الأول -->
            <div class="grid md:grid-cols-4 gap-3">
                <div>
                    <label class="{{ $labelClass }}">اسم المستفيد</label>
                    <input type="text" wire:model="beneficiary_name" class="{{ $fieldClass }}" />
                    @error('beneficiary_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">تاريخ البيع</label>
                    <input type="date" wire:model="sale_date" class="{{ $fieldClass }}" />
                    @error('sale_date') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">نوع الخدمة</label>
                    <select wire:model="service_type_id" class="{{ $fieldClass }}">
                        <option value="">-- اختر --</option>
                        @foreach($serviceTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('service_type_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">المزود</label>
                    <select wire:model="provider_id" class="{{ $fieldClass }}">
                        <option value="">-- اختر --</option>
                        @foreach($providers as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    @error('provider_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- الصف الثاني -->
            <div class="grid md:grid-cols-4 gap-3">
                <div>
                    <label class="{{ $labelClass }}">الوسيط</label>
                    <select wire:model="intermediary_id" class="{{ $fieldClass }}">
                        <option value="">-- اختر --</option>
                        @foreach($intermediaries as $i)
                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                        @endforeach
                    </select>
                    @error('intermediary_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">العميل</label>
                    <select wire:model="customer_id" class="{{ $fieldClass }}">
                        <option value="">-- اختر --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">الحساب</label>
                    <select wire:model="account_id" class="{{ $fieldClass }}">
                        <option value="">-- اختر --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                    @error('account_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">الإجراء</label>
                    <input type="text" wire:model="action" class="{{ $fieldClass }}" />
                    @error('action') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- الصف الثالث -->
            <div class="grid md:grid-cols-4 gap-3">
                <div>
                    <label class="{{ $labelClass }}">USD Buy</label>
                    <input type="number" wire:model="usd_buy" step="0.01" class="{{ $fieldClass }}" />
                    @error('usd_buy') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">USD Sell</label>
                    <input type="number" wire:model="usd_sell" step="0.01" class="{{ $fieldClass }}" />
                    @error('usd_sell') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">الربح</label>
                    <input type="number" wire:model="sale_profit" step="0.01" class="{{ $fieldClass }}" />
                    @error('sale_profit') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">المبلغ المدفوع</label>
                    <input type="number" wire:model="amount_received" class="{{ $fieldClass }}" step="0.01" />
                    @error('amount_received') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- الصف الرابع -->
            <div class="grid md:grid-cols-4 gap-3">
                <div>
                    <label class="{{ $labelClass }}">المرجع</label>
                    <input type="text" wire:model="reference" class="{{ $fieldClass }}" />
                    @error('reference') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">PNR</label>
                    <input type="text" wire:model="pnr" class="{{ $fieldClass }}" />
                    @error('pnr') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Route</label>
                    <input type="text" wire:model="route" class="{{ $fieldClass }}" />
                    @error('route') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">اسم المودع</label>
                    <input type="text" wire:model="depositor_name" class="{{ $fieldClass }}" />
                    @error('depositor_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- الملاحظات تأخذ صف كامل -->
            <div class="md:col-span-4">
                <label class="{{ $labelClass }}">ملاحظات</label>
                <textarea wire:model="note" rows="2" class="{{ $fieldClass }}"></textarea>
                @error('note') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="text-center pt-4 flex flex-col sm:flex-row justify-center gap-3">
                <button type="submit"
                    class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold px-6 py-2 rounded-xl shadow-md hover:shadow-xl transition duration-300 text-sm">
                    حفظ العملية
                </button>

                <button type="button" wire:click="resetFields"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold px-6 py-2 rounded-xl shadow transition duration-300 text-sm">
                    تنظيف الحقول
                </button>
            </div>
        </form>
    </div>

    <!-- جدول العرض -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-xs text-right">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-2 py-1">التاريخ</th>
                        <th class="px-2 py-1">المستفيد</th>
                        <th class="px-2 py-1">العميل</th>
                        <th class="px-2 py-1">الخدمة</th>
                        <th class="px-2 py-1">المزود</th>
                        <th class="px-2 py-1">الوسيط</th>
                        <th class="px-2 py-1">Buy</th>
                        <th class="px-2 py-1">Sell</th>
                        <th class="px-2 py-1">الربح</th>
                        <th class="px-2 py-1">المبلغ</th>
                        <th class="px-2 py-1">الحساب</th>
                        <th class="px-2 py-1">المرجع</th>
                        <th class="px-2 py-1">PNR</th>
                        <th class="px-2 py-1">Route</th>
                        <th class="px-2 py-1">الإجراء</th>
                        <th class="px-2 py-1">الموظف</th>
                        <th class="px-2 py-1">خيارات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-1 whitespace-nowrap">{{ $sale->sale_date }}</td>
                            <td class="px-2 py-1">{{ $sale->beneficiary_name }}</td>
                            <td class="px-2 py-1">{{ $sale->customer->name ?? '-' }}</td>
                            <td class="px-2 py-1">{{ $sale->serviceType->name ?? '-' }}</td>
                            <td class="px-2 py-1">{{ $sale->provider->name ?? '-' }}</td>
                            <td class="px-2 py-1">{{ $sale->intermediary->name ?? '-' }}</td>
                            <td class="px-2 py-1 text-green-700 font-semibold">{{ number_format($sale->usd_buy, 2) }}</td>
                            <td class="px-2 py-1 text-red-700 font-semibold">{{ number_format($sale->usd_sell, 2) }}</td>
                            <td class="px-2 py-1 text-blue-700 font-semibold">{{ number_format($sale->sale_profit, 2) }}</td>
                            <td class="px-2 py-1">{{ number_format($sale->amount_received, 2) }}</td>
                            <td class="px-2 py-1">{{ $sale->account->name ?? '-' }}</td>
                            <td class="px-2 py-1">{{ $sale->reference }}</td>
                            <td class="px-2 py-1">{{ $sale->pnr }}</td>
                            <td class="px-2 py-1">{{ $sale->route }}</td>
                            <td class="px-2 py-1">{{ $sale->action }}</td>
                            <td class="px-2 py-1">{{ $sale->user->name ?? '-' }}</td>
                            <td class="px-2 py-1 whitespace-nowrap">
                                <button wire:click="duplicate({{ $sale->id }})"
                                    class="text-emerald-600 hover:text-emerald-800 font-medium text-xs mx-1">تكرار</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="17" class="text-center py-4 text-gray-400">لا توجد عمليات بيع</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($sales->hasPages())
            <div class="px-4 py-2 border-t border-gray-200">
                {{ $sales->links() }}
            </div>
        @endif
    </div>
</div>