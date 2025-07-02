<div class="max-w-4xl mx-auto mt-12 bg-white/80 backdrop-blur-md p-8 rounded-3xl shadow-2xl border border-emerald-200">
    <h2 class="text-3xl font-extrabold text-emerald-700 mb-10 text-center">إضافة عملية بيع</h2>

    <form wire:submit.prevent="save" class="space-y-6 text-lg">
        @php
            $fieldClass = 'w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white text-base';
            $labelClass = 'block mb-2 px-3 py-2 bg-gray-100 border border-emerald-200 rounded-xl text-gray-800 font-bold text-base shadow-sm';
        @endphp

        <div class="grid md:grid-cols-2 gap-6">
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
        </div>

        <div class="grid md:grid-cols-2 gap-6">
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
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="{{ $labelClass }}">الوسيط</label>
                <select wire:model="intermediary_id" class="{{ $fieldClass }}">
                    <option value="">-- اختر --</option>
                    @foreach($intermediaries as $i)
                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="{{ $labelClass }}">USD Buy</label>
                    <input type="number" wire:model="usd_buy" step="0.01" class="{{ $fieldClass }}" />
                </div>

                <div>
                    <label class="{{ $labelClass }}">USD Sell</label>
                    <input type="number" wire:model="usd_sell" step="0.01" class="{{ $fieldClass }}" />
                </div>
            </div>
        </div>

        <div>
            <label class="{{ $labelClass }}">ملاحظات</label>
            <textarea wire:model="note" rows="4" class="{{ $fieldClass }}"></textarea>
        </div>

        <div class="text-center pt-6">
            <button type="submit"
                class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold px-10 py-3 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                <svg class="inline w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
                حفظ العملية
            </button>
        </div>
    </form>
</div>
