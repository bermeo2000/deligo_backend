<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategoriasTiendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categoria_tiendas = [
            [
                'Ropa',
                'https://previews.dropbox.com/p/thumb/ACCbgqLsnJS9_kLVY5fa_AIpyJRAwEkpyYIWt03RJcFXy6uO4sQahtj1wBlZspYfxHGbsqiTCkgrGgc3ygIrs-FFQfc0TrL3yHt8g4dLvI26dshVTgn15E1u8z6lr_QfzVvICBmh7NqX0-BLdlQeBB-QjGvLRunxtMkQWR0ciHDs71MuDl5P_4s4ynxWgIs724su4cpXlnTEy3WRrWs35FPH2zz_3WEZiem9n2S4lWNwoBBZQixpP4JS-tgRgjcyTX_m11L84LoLtDdZTk1KoOQT-ZYp7ngsHdG5UaMA13ZSTAq7NzW5oAEfagB0hTYp3UO27ZwD1bVzeIQ32Je_OA-r/p.png',
                1
            ],
            [
                'Comida',
                'https://previews.dropbox.com/p/thumb/ACC8gCreiXuVa-uFkBoxPMlsFwoxKU1wP5LI3z4QTCrd7d73EniJ9mHgkjKP-VqlwgDdH5zT7FKpPixRbCcqELqxMaMIKtESV9Ul-8UXPKIie-MfUOyjL297YFnGpxc0STFiC4lRumsgKLekhDBi6WGJrnpHse6WMc9tlxdx5VBdmBiiLfgoSHBHdTmAPx1yfaG5O18fh0VwJRmMMFNgBMVY-tgWx1pFtlWVKoLP4eWUz-h_LSXBRZWlo1XLYTLLBS8SBw135Q-x3lUPLU-QasVPtJaA9O-BiLd-ARsUhWjBhrD9-R5LhvcPwVJzl0XNp7vjGsE9GMHWP-qbMURTEgm7/p.png',
                1
            ],
            
            [
                'Electrónica',
                'https://previews.dropbox.com/p/thumb/ACA3z1UOFbZvyYDVvmBN-kzJM7St0prCujrcsAl9111ESP2Vtu64Opysgb5VEhA-4-F9QXJy8uX518BKSf9Pn1-qdHdZ0EuUi5-EtFEjrCQki_ZTlfFUP7qPjmy796oLFXm4gBZi-QPDRRPL3J8rhcgkCaP2BVWLv97RTb6rx56yRW69ESxOmTdThqwW1GYpQ2P_AzP5cH0jnwWf7AYzJNK3sMqm3uC0x6Bmz216hcZB2l40Gi7-RkmcFsEM9VlZgYd8x6FFR_kqZl7s0z5D7NXtTjVNxjnZL1oQgzOFjdTxCiE5IjvJO86IDrJRQlwLmvPRimpG_ABjzFRhn4hrV-ea/p.png',
                1
            ],
            [
                'Calzado',
                'https://previews.dropbox.com/p/thumb/ACByxwQYAB8UDflCLOD75gfiGpdv1h77t7aAS1zGJhwARmtWmcqSlxRSW_-fesPML_5A11Q8Qz_rY7sJcsfxKSEr_xcYH3X2SxiTJkR7IUPOepqV8Y171GI6S61jw9umZNtzhr7-h_ZEzOmRMkOsZfJcmMt2--MONWCqgvrSR-Va6g4U2_YSoR9vsWgxTVdcssW5panNRt9mEp_h7ya-7H1YWt1HuJhVEHXPABo-cPbd5pPmPDadD68eGRuT3anxi3LOiBsatbt3CE5_qSQ2BbRvjh50p46NIpCwzckYTSsarFlfHC5ozCCbC0SkspDSppJcjldLX-NeQmdj5FMpkCPM/p.png',
                1
            ],
            [
                'Accesorios',
                'https://previews.dropbox.com/p/thumb/ACAcUi6SKrWsnuhZHrh8jdnQztX9EXeMUZHC5RBz0t3rPHloZLUtSWaGVr7j0bbfsCHRH_sFcXANWCAZWH2NHwmOIqvqX4QIkvGDLTBAOhu_xpMay3C_jE-54V0Fqxi-xMKz31aeicfdQ_drLAJu7blHOlH_46yVM7ULTD6yrCXh-yBPq7sEM6PPhvng6p7suHEV3lYO5atmLcgQeX_ko530Uqv_nd0erBvn4zIPy840Ss7XFjKCTVkGFwMWHtI4l9auOfNVmJvUhPteU9YnzH6ULRSzPKoSIgqAsmn0mlC0Auiy7xzQeO0jDMjW1KQXgjEwbOOlSVVASWlT9-HhXA-f/p.png',
                1
            ],
            [
                'Mascotas',
                'https://previews.dropbox.com/p/thumb/ACChEPkoEF_y7GxlRn4hkOCVRmOB1hsMH6QgreEOHpLepttSR4vs1gP9UZQvpdnntcwpQGzCioDLNKtYwTSBvPScbO2gXGHnve0t6nBzj_etgEcvcb6xmvK3VWYV5xzXzSP6yekePfWusgq8mWtChCnmNDJflX5FEs8CE-s5Y6IIFYuOA3bmnvGCj9d7mxfXy4cJ6YNeM5fmQGTXgjXbxZ4rxKFZ5Zk1nr6FsdsA7ZYd_Cwa8H9x4VJ-W87Qt1-3KozbuMtM_ewba__TnmbXpvlzZ59u27_R3d0AWx0gC3OQlIq4XTBe-lt6REOmMOfPLgKPxJECBwX9zAnY2t001bGm/p.png',
                1
            ],
            [
                'Hogar',
                'https://previews.dropbox.com/p/thumb/ACCE2pydSiG8yB_W2dfStBm_Pt9Jc2iWGk6hfuQ6mEIygOChxqnU49xORKPrMNdc-iEEiBDf4cyO6502xxmC9FtTTTacJk3U1kypyQqG8RgnkfgvOY_An9UBgyX4oYfGIHMkJjwiYYdwA9BkwZ954rXOrXA1CnSkgJRqFkXZqHcpm5g446-bDX-NVn2klLpcf42tTAgDOngIiaO3tm9vHfBRET6jYEez8SHBn7m1CbUJH4088RBE8ydkZzzVJqDUmjvlunZOBmpQw4FG61pEGHlyULx-alcjXuIsbGVG20TMfsPVztfF_c-KOLGbYc8kRsaukRcqOYV-Q2dGAaOMUhsR/p.png',
                1
            ],
            [
                'Otros',
                'https://previews.dropbox.com/p/thumb/ACCrQKW14AQwjqSs5TN_uCdBREQFty_90z8DH_tSV2ohZHmToZudyAMx9GeJyNND6aM-AwqnGgn9oY6nnswpzYZU5-GHM_EWq08_1BJviNKIMSg3TJda5g3dm4lSlS1wfNmgUrXpXnN8rm5F4J8cfrfD5dNzKzLfjAtwP-MV6DeHd44DtfllaaE8RSmNZKIFPbyc_1wa24BrLVBN7956PCU1q6YtWQ7oXGnIMGhsn8nAcDhspm-h3H4ZdC76g37tvI-spRGQI4Y_4Uppfi8l2bHbD972ppgOP2NRRXi9glllb29hFcIX_-YNh7_6Tq7ThrtBqDskDRas2QZZrvD1v6rD/p.png',
                1
            ]

       ];

        foreach($categoria_tiendas as $ct){
            DB::table('categoria_tiendas')->insert([
            'nombre' => $ct[0],
            'imagen' => $ct[1],
            'estado' => $ct[2],
        ]);
        }
    }
}
