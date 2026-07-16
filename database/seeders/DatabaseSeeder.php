<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Maintenance;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate([
            'email' => 'admin@multitech.test',
        ], [
            'name' => 'Admin MTI',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $tech1 = User::updateOrCreate([
            'email' => 'teknisi1@multitech.test',
        ], [
            'name' => 'Teknisi Satu',
            'password' => Hash::make('password'),
            'role' => 'teknisi',
            'is_active' => true,
        ]);

        $tech2 = User::updateOrCreate([
            'email' => 'teknisi2@multitech.test',
        ], [
            'name' => 'Teknisi Dua',
            'password' => Hash::make('password'),
            'role' => 'teknisi',
            'is_active' => true,
        ]);

        $items = [
            [
                'code' => 'ALT-001',
                'name' => 'OTDR EXFO M1',
                'category' => 'Pengukuran',
                'stock' => 4,
                'status' => 'normal',
                'description' => 'Alat uji fiber optic jarak jauh.',
            ],
            [
                'code' => 'ALT-002',
                'name' => 'Fusion Splicer 90S',
                'category' => 'Penyambungan',
                'stock' => 2,
                'status' => 'servis',
                'description' => 'Mesin penyambung kabel fiber optic.',
            ],
            [
                'code' => 'ALT-003',
                'name' => 'Power Meter PON',
                'category' => 'Pengukuran',
                'stock' => 6,
                'status' => 'normal',
                'description' => 'Pengukur daya optik jaringan PON.',
            ],
            [
                'code' => 'ALT-004',
                'name' => 'Fiber Cleaver FC-6S',
                'category' => 'Penyambungan',
                'stock' => 1,
                'status' => 'rusak',
                'description' => 'Pemotong presisi serat optik.',
            ],
        ];

        foreach ($items as $itemData) {
            Item::updateOrCreate(['code' => $itemData['code']], $itemData);
        }

        $loan = Loan::updateOrCreate([
            'user_id' => $tech1->id,
            'item_id' => Item::where('code', 'ALT-003')->value('id'),
            'status' => 'approved',
        ], [
            'requested_qty' => 1,
            'approved_qty' => 1,
            'requested_at' => now()->subDay(),
            'approved_at' => now()->subDay(),
            'due_at' => now()->addDays(2)->toDateString(),
            'notes' => 'Pengerjaan link pelanggan area Batam Center.',
        ]);

        Maintenance::updateOrCreate([
            'item_id' => Item::where('code', 'ALT-002')->value('id'),
            'type' => 'corrective',
        ], [
            'loan_id' => $loan->id,
            'maintenance_date' => now()->toDateString(),
            'condition_after' => 'servis',
            'notes' => 'Kalibrasi ulang untuk stabilitas arc.',
        ]);
    }
}
