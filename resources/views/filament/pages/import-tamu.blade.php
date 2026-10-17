
<x-filament-panels::page>
    <style>
        .it-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .it-card {
            background: var(--fi-color-bg, white);
            border: 1px solid var(--fi-color-border, #e5e7eb);
            border-radius: 14px;
            padding: 24px;
        }

        .it-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 6px;
        }

        .it-description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .it-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .it-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .it-required { color: #dc2626; }

        .it-input {
            display: block;
            width: 100%;
            box-sizing: border-box;
            min-height: 43px;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: transparent;
            color: inherit;
            font-size: 14px;
        }

        .it-help {
            color: #6b7280;
            font-size: 12px;
            margin-top: 8px;
            line-height: 1.5;
        }

        .it-error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 7px;
        }

        .it-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid var(--fi-color-border, #e5e7eb);
        }

        .it-result-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-top: 18px;
        }

        .it-result {
            padding: 18px;
            border: 1px solid var(--fi-color-border, #e5e7eb);
            border-radius: 10px;
        }

        .it-result-label {
            color: #6b7280;
            font-size: 13px;
        }

        .it-result-value {
            font-size: 28px;
            font-weight: 700;
            margin-top: 8px;
        }

        .it-errors {
            margin-top: 20px;
            padding-left: 20px;
            list-style: disc;
            font-size: 13px;
            line-height: 1.8;
        }

        @media (max-width: 700px) {
            .it-card { padding: 17px; }
            .it-form-grid, .it-result-grid {
                grid-template-columns: 1fr;
            }
            .it-actions {
                justify-content: stretch;
                flex-direction: column;
                align-items: stretch;
            }
            .it-actions > * { width: 100%; }
        }
    </style>

    <div class="it-page">
        <section class="it-card">
            <h2 class="it-title">Impor Daftar Tamu</h2>

            <p class="it-description">
                Tambahkan banyak tamu sekaligus ke undangan pilihan.
                Gunakan file CSV UTF-8 dengan ukuran maksimal 5 MB.
            </p>

            <div class="it-form-grid">
                <div>
                    <label for="invitationId" class="it-label">
                        Undangan Tujuan <span class="it-required">*</span>
                    </label>

                    <select
                        id="invitationId"
                        wire:model="invitationId"
                        class="it-input"
                    >
                        <option value="">-- Pilih Undangan --</option>

                        @foreach ($this->invitations as $invitation)
                            <option value="{{ $invitation->id }}">
                                {{ $invitation->title }}
                            </option>
                        @endforeach
                    </select>

                    @error('invitationId')
                        <p class="it-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="file" class="it-label">
                        File CSV <span class="it-required">*</span>
                    </label>

                    <input
                        id="file"
                        type="file"
                        wire:model="file"
                        accept=".csv,.txt"
                        class="it-input"
                    />

                    <p class="it-help">
                        Format CSV UTF-8, maksimal 5 MB.
                    </p>

                    @error('file')
                        <p class="it-error">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="file" class="it-help">
                        Mengunggah file...
                    </div>
                </div>
            </div>

            <div class="it-actions">
                <x-filament::button
                    color="gray"
                    icon="heroicon-o-document-arrow-down"
                    wire:click="downloadTemplate"
                >
                    Unduh Template CSV
                </x-filament::button>

                <x-filament::button
                    color="info"
                    icon="heroicon-o-users"
                    wire:click="exportGuests"
                    wire:loading.attr="disabled"
                    wire:target="exportGuests"
                >
                    Ekspor Daftar Tamu
                </x-filament::button>

                <x-filament::button
                    icon="heroicon-o-arrow-up-tray"
                    wire:click="import"
                    wire:loading.attr="disabled"
                    wire:target="import,file"
                >
                    Impor Tamu
                </x-filament::button>
            </div>
        </section>

        @if (! empty($importSummary))
            <section class="it-card">
                <h2 class="it-title">Hasil Impor</h2>

                <div class="it-result-grid">
                    <div class="it-result">
                        <div class="it-result-label">Berhasil ditambahkan</div>
                        <div class="it-result-value">
                            {{ number_format($importSummary['created']) }}
                        </div>
                    </div>

                    <div class="it-result">
                        <div class="it-result-label">Dilewati</div>
                        <div class="it-result-value">
                            {{ number_format($importSummary['skipped']) }}
                        </div>
                    </div>
                </div>

                @if (! empty($importSummary['errors']))
                    <h3 style="font-weight:600;margin-top:24px">
                        Catatan impor
                    </h3>

                    <ul class="it-errors">
                        @foreach ($importSummary['errors'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    @if ($importSummary['total_errors'] > count($importSummary['errors']))
                        <p class="it-help">
                            Menampilkan 20 catatan pertama dari
                            {{ $importSummary['total_errors'] }} catatan.
                        </p>
                    @endif
                @endif
            </section>
        @endif
    </div>
</x-filament-panels::page>
