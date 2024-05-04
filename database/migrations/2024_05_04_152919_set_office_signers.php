<?php

use App\Enums\SignerAs;
use App\Enums\SignerAuth;
use App\Models\OfficeSigner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $signers = [
            [
                'name' => 'Lucas Santana de Oliveira',
                'document' => '06575305300',
                'signer_id' => '31d5ac54-3563-4492-a949-4685d1cd6a4d',
                'auth' => SignerAuth::API->value,
                'sign_as' => SignerAs::WITNESS->value,
                'secret' => '-----BEGIN RSA PRIVATE KEY----- MIIEpQIBAAKCAQEAoHRyaPojZbfbKZ1vYCTzJ9AhybfdFP4iehBD668/rkVtUQor mUOPvqvvQoHo2vleuP9dSvfIk23hmIp5SP92KHodCDcJHcXcM4IIBk5BL17EOMYw c2P1JeKyXR4afrmQ6cH7vOUbofHlOJmHNI1mNJIIhcoL6sxEAlKMo+00nqOEp9ka tBj3WLvmEcet87BaAkUBxGcg9YS23PVe7nQ1VUyA507u/unIqTNtPfooCW+KcMd2 kECF12IH4zPJ0iGCe62NH1J1nWKYiGW/Ob6DghbxSfkol+6Ph4UgS848r66liMq0 1LcfwX6xuJAfeVHRNCX0D1RZ+T4OUs7V9C3+wwIDAQABAoIBAErUg9b5cTCrAgby aVLJaK0Un+1XVj/IFYQfuc1cubIopsa4m4SqwYsG3FqEA3i7+7UDQxsHW/+Fq0Rc sBufKBfQe2GtaQ79i6hp6BwourXA2Hox0768y0OT6eMLewfGuxKJaUG7B5wLF//B ehDEMPorcNYUWGJ0SPNcVELPCU9B7f7SJKi4T5+OsWHmESUO2eOEamyGgLqaIva5 q2Fi+eFiiYh7NxgZR4ZC0tEcq2srfxdFALXySLO7wu4HJjJVrzBp0DzdjhikKLYp 9MJ1qU5Wo/JwO/M7UD7eyEaqsuWFa7qdbiZvl0CCIMJHkWvMk8zCdpWPAAwTz6jJ v94/FwECgYEA1T2GZxFbLzdx3TbVgK3M7uaCcsetYZjsYeRcTQQeyCMYX4kVWdh5 hbIc/HjX38mhnsYN5Fi8r3BkRIBypvqp/IWglwNM0NB9Gw+A5H2MchW9nN0ltU8N Wmxx62K7PphawraZ2pZGnb4IA4mdgNEQfncP1iT8iCk/er4/JfKZAyMCgYEAwKE7 7HeUq418anq6iR0Dn8GMopzDjbNHLGQjha2BUn2mYuAlJiiuHLVEZfLv/TPrc6Jh uajD37ud/O4CzQ9zwhURAoRNpsI5NDbWFqLHmJOD05hhBBdVkcIQgANZeILN3JbQ HyDOzlVmygV3u0ZGN9L6jIsuD5EtNyw4POv7H+ECgYEAsrmDecVpSLTO4ZtA7T4+ gol/Elbbse5rSU0OM5rddd88YW5TD9/JUs5LTyy1uqKTrLDRGe9qDh1EXMnPzrZP XRBe3dNtQaNNCC5BWMEFwuUH7H7KSSF9zqkP/jrdN4SYpZRIdZX4j+OjcduYwEv5 6BVAl7qeUj1IMEdeRB8GMkMCgYEAkqjvf81XsvmpFUTVytj9Tl/FXHVwae1qLgEc DoYYZR7nVHaFsjTcw1y7c8dwMt6Z0FN8hidY4nntAoqQNWIjZ0w0xC7JFELh3MA3 ZcqPnroJb0uf6cZ+TthrSZvDPf6RD/b/BAQtkGjzNrLNAxexFIWcXu8EpbOJsm0H cFLWwuECgYEAmvyHHUrgp3LY29+sNcGwap16bbg3l5X06ZwS3s8GzULbViQRB5RE 8rNUkcLQi7Fb9w1iWmNNOuXHepXskEYvkByVOe4B6EA8YnVJ666zemkG0c+CG49Y lq+Od14MIBI7Czkux5IJZmKBwXQDhPdihZWVZNXzsUx/2VIww1mMIWE= -----END RSA PRIVATE KEY-----'
            ],
            [
                'name' => 'Eduardo Batista Alves',
                'document' => '07889759517',
                'signer_id' => '7500db3e-ec81-4de7-8b3e-37229d74bbe5',
                'auth' => SignerAuth::API->value,
                'sign_as' => SignerAs::WITNESS->value,
                'secret' => '-----BEGIN RSA PRIVATE KEY----- MIIEpgIBAAKCAQEA3ukvRjyzxfDyVeQ81fz8q0HCtpTPIApyNWvcqPDJvobjSPZj wxsEWp6nF/vsNihvLQsxCursGYR25ta6KGzQdAr7MEN9Ro3yzxOMi44wXv7Xy4Sw 1BTBWtG+/tp/88g60Raq3LZgqdF81Gejd+5V80pDuM8KV1SrL2Ait9NG6jX0GbWt GLwDyO0whTcADXsENU4hov4EcTR3MyVsJkU255RlBQPTZnFbpTdtoMS9IDrXNA/5 EYzFuWqBk/9LB+oYyWpVM3m/PwIxDGGiftSOcT7BAayNvlu+G4wzsC6w6x3Sj9zc N8f3axiQ5jP1Fc+hf3xXmb/R+EizWqkhiDYdNwIDAQABAoIBAQCji2wu2QyAtqXl 1J251nI+5/GG6akJdgCTJz7vCDLMQcTx3CwXknPgVLR9iUyl84aWArcJrpBorGJc PMC6NhO+f+wJXgrEwBKcUVh1b24X1FvZKtJd15iBHJBIBWGJJ6fXjgzwADLthRBT +nHZ5RhUdnE3X1fT+P/bs2nlevJ1lJ7fPKjvIGnFu/Gc588EQ88en80dGExcImwr UVIJW65J3PDIF451RQTtX2zTZVbR/ctW2B67afhOQfkhypWpsFnV6kZx1pveJyAf E36KXLrNJX9++lkHFHykbOvLSQpU445x2++jCQ0sp+Q3zql7TBiWQMOG6sfXGhdG Fib+M97RAoGBAP+AWC6W8m+DUxsXiwHqC9biV87dW5j+1GLgbM+TczCOyRh8IiO0 +h68HXsXhR0fQ72SUe/m8rfwb1AKr/MMZBIi5kiLbaoNGPx7FfGKgo65wjilhsJm sF/71M8gaEhoOTCFjWBo96k1OW2IDAdyBVXjruHYAjigFAf8abF68Ro/AoGBAN9Y jp51TO0KTwBCrr7nQw3QRs8+zddDbEk24k2PUu83SGmasGHH54iLAvI0/O8Qt09c B/VPVaKOUuauLleijqto0xbqWSgLLDKHADfr+HvFAhXAEPzSlxF5EBjQbUH92rpy /c8ScUIRUjbqDamu0Dt8O+TqZjs7B6bjviFVLY8JAoGBAMkbu81IMSGHK+X6PQdP suv8EwOYBt5BTulZHyywMg35hd4I71JNxEZm6YmW9Mb8cfSIdIgxr8EKtoM5Nk9H 5IjGAZ7+aF5emtk5BQevb55qJq8x0wW3kIKslVBHgO3lY4aGyMYnOTFt3HsTh+xg WkTFx0SrIuxxS/MRQhxZ2ec/AoGBAMmJ3dg7PRlBDhzMD2eQw785TExC/ffbjWFb t0YJqOrX1e4FelghzVo3JodtLTiEuwVPpJbF6h5vk3s5ffPyag9e3ex1t9Ickttd WuMbefQlyEXcNPgPB+bqeY4KtiywZ6mLjmBG4hCeFLQc7AtMBfdHmbxtj6avE66T H8RwWlYRAoGBAOdLhl8HvUZoTNtZkunBKPZLFLYN8F3uzeadbXIPbntLnCA+mVKn fNnekCTDV2VuQrFbcR5X8681a0c+9ocyEgkmTW7/abG2r/PSfaKaLL8ohc58qyEv y7IvjX54hI6AvHtTyt6ibOAITL5METX3OBIpnZKqLjOst6T+VwQyoPK4 -----END RSA PRIVATE KEY-----'
            ],
            [
                'name' => 'Josué Leite de Lima Junior',
                'document' => '00500711577',
                'signer_id' => 'e3546286-8bea-45e8-9be2-8523f882fa32',
                'auth' => SignerAuth::API->value,
                'sign_as' => SignerAs::PARTY->value,
                'secret' => '-----BEGIN RSA PRIVATE KEY----- MIIEpAIBAAKCAQEApAP/C5RK1hc655aMCjnRI7oP58bDu+V7zVfPRsSlrQ06tar7 r5JW5WNP7Q1JR4MZbAWZWWVK5w/iAg2IIMX+KWCELzf3v/W1O4eeVawR0ZhGFYA4 VYtH9n6BdtJL9UKqZvrSJhe/3cIM2rjUtkYZhHPTGiGnLPGd5VrpuJdqZaVHOE0j JYcyV+XndsL63yRm8HdrXyzOiLXhbDkF8C3vkbPtaj19DyD2S91g/7iphsySFr6I UJWrR51fim0HHGrAxa3sheR58qP2eNHH2NsYCkMB8SfLNyeUMy8A68Bw4dLpanb6 a4d7RuRpHhAre4mkFEZYBAQ8KEU176oU774F7wIDAQABAoIBAFji5Yyj8C64Zi7t 8rT0AninNEl6+cbRpldxmB6VIeh3+/JKWJ4c48TrHnysr6L21IcrPaEp+P7iJ6zP IpAIXSaVbO2eGkFI6s/5PoDVgM6jBJBQbbdGhVh71LPNYmbnmyu2EL+eLVgD+y1p 77VcpiWXE7fctxnvU4/hxjpIrNuqaaS8FeCqZbThgST1MggLY4jJvGfFQV2+PVv+ 2yMUeEuKhPyfJaK7Jc2BaZ9HzneSjaGIqEBr3yDLjwazGDWsv6BYKv+d8Hk3jDiO 2Vxbi8dHLsSfL/Pt69IrvPwitRUZDTreXoAZ2VHO0ruI3mHsVJaCjlpU1bRnTfag awFVtZkCgYEAzjWQl7F11tFbaLnAmB62+zKBdqvSHSHCuqBiyx0xuG32iat+ELNo K70swYgS984L+FmiKhDY81a0Fc0IexdtL1jpLMomXcUdDSqrPZgX8aAW1RFs3pQR +BjVqo+7hDKp0Hk8johbnnExK/tVYptslI/5LKlaYLdHbSlmvVeVpqsCgYEAy55P 3GJxVYiqcJ9AxPw6RvlDxSHwZCCNzTzIIV3alL1/jqNHHaKpqH7pFLC3NC4wa89U gRHB9GNhgFR3vByYrZekYiYNF7jnhZHpJPtO917e+NeV7gF1Dra38FVu+pFgetxt 6VJVwF3KNqOLGwZAjFfI8WWcXwEA4YintNnSrc0CgYEAyza8ZNGMyIOPKpiL9R2n w8uVDCbtrKndpl9ynKoLmq47XJa1aK31Bc2rMpnv32eeIkPq7Lunob8bP7TMG8oN XrCnMe2Re61KIPSgxtWBGyxh8931RS/0uWN4BVsaN4BaG0mu5OP6Lh1skORh1AhJ K+rqaxoGJ/PWnvxC9GtA3nsCgYBMC4gP6sQhCbV98jwiVYD+WMGysgYxnubWq8ii jYbA3jTxdJFuw/1Q7HToQUdquYVj/j61JYimWSdk4icFnjh3PJcsAMILBgeRnvjP 0vue71Oe5AUeqnSpVhxEKeQUuI6r0/9IkHNuMJkA5vtg0GjzASYO4cAQyzMlCAB6 To+cUQKBgQCjY2Ga0uDhfgw2HUz5y5YmezWX5GNS4o+LSC91HFiWIPdTZkTYOKM2 7DlFTGnsg7i9qpEp62xTulci8YjwCsJGAlgKrqav4tF+Yn1HbBbknaSXvrn16SHP 3lOs5O9hZKgEQMhFR1iU0JAzi94YtbuxM1BlcOMVwQoOTdyS5rsYLg== -----END RSA PRIVATE KEY-----'
            ],
        ];

        OfficeSigner::query()->delete();
        foreach ($signers as $signer) {
            OfficeSigner::create($signer);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
