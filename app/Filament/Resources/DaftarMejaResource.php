<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DaftarMejaResource\Pages;
use App\Filament\Resources\DaftarMejaResource\RelationManagers;
use App\Models\DaftarMeja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\HtmlString;

class DaftarMejaResource extends Resource
{
    protected static ?string $model = DaftarMeja::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Manajemen Operasional';
    protected static ?string $pluralModelLabel = 'Daftar Meja';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_meja')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_meja')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('qr_code_path')
                    ->label('Status QR')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->trueColor('success')
                    ->falseIcon('heroicon-o-x-circle')
                    ->falseColor('danger'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Lihat QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    // Method modalContent sekarang akan me-render sebuah view
                    ->modalContent(function (DaftarMeja $record): \Illuminate\Contracts\View\View {
                        $qrCodeUrl = null;
                        // Hasilkan URL lengkap untuk meja ini
                        $fullUrl = url('/?meja=' . $record->id);

                        // Cek apakah file QR code sudah ada
                        if ($record->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($record->qr_code_path)) {
                            $qrCodeUrl = \Illuminate\Support\Facades\Storage::url($record->qr_code_path);
                        }

                        // Panggil file view dan KIRIM SEMUA DATA yang diperlukan ke dalamnya
                        return view('filament.modals.qr-code', [
                            'namaMeja' => $record->nama_meja,
                            'qrCodeUrl' => $qrCodeUrl,
                            'fullUrl' => $fullUrl, // <-- Pastikan baris ini ada
                        ]);
                    })
                    ->visible(fn(DaftarMeja $record): bool => !empty($record->qr_code_path)),

                Action::make('generateUlang')
                    ->label('Generate Ulang QR')
                    ->icon('heroicon-o-arrow-path') // Icon refresh
                    ->color('gray')
                    ->requiresConfirmation() // Meminta konfirmasi sebelum menjalankan
                    ->modalHeading('Buat Ulang QR Code')
                    ->modalDescription('Apakah Anda yakin ingin membuat ulang file QR Code untuk meja ini? File lama (jika ada) akan ditimpa.')
                    ->modalSubmitActionLabel('Ya, Buat Ulang')
                    ->action(function (DaftarMeja $record) {
                        // Logika ini sama persis dengan yang ada di afterCreate()
                        $path = 'qrcodes/meja-' . $record->id . '.svg';

                        $qrCode = QrCode::format('svg')
                            ->size(300)
                            ->generate(url('/?meja=' . $record->id));

                        Storage::disk('public')->put($path, $qrCode);

                        // Update record di database dengan path yang baru
                        $record->update(['qr_code_path' => $path]);

                        // Kirim notifikasi bahwa proses berhasil
                        Notification::make()
                            ->title('QR Code berhasil dibuat ulang')
                            ->success()
                            ->send();
                    })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDaftarMejas::route('/'),
            'create' => Pages\CreateDaftarMeja::route('/create'),
            'edit' => Pages\EditDaftarMeja::route('/{record}/edit'),
        ];
    }
}
