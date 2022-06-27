<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Menu;
class TenantMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus=array(
            array(
                "id" => 1,
                "name" => "Header",
                "position" => "header",
                "data" => '[{"text":"Home","href":"/","icon":"","target":"_self","title":""},{"text":"Products","href":"/products","icon":"empty","target":"_self","title":""},{"text":"Menu","href":"/menu","icon":"empty","target":"_self","title":""},{"text":"Contact","href":"/contact","icon":"empty","target":"_self","title":""},{"text":"Pages","href":"#","icon":"empty","target":"_self","title":"","children":[{"text":"Cart","href":"/cart","icon":"empty","target":"_self","title":""},{"text":"Checkout","href":"/checkout","icon":"empty","target":"_self","title":""},{"text":"login","href":"/customer/login","icon":"empty","target":"_self","title":""},{"text":"Register","href":"/customer/register","icon":"empty","target":"_self","title":""},{"text":"Thanks","href":"/thanks","icon":"","target":"_self","title":""},{"text":"Terms and conditions","icon":"","href":"/page/terms-and-conditions","target":"_self","title":""}]},{"text":"Blogs","href":"#","icon":"empty","target":"_self","title":"","children":[{"text":"Blogs List","href":"/blog","icon":"empty","target":"_self","title":""},{"text":"Blog Details","href":"/blog/bottled-water-home-delivery-companies","icon":"empty","target":"_self","title":""}]},{"text":"Customer","href":"#","icon":"empty","target":"_self","title":"","children":[{"text":"Dashboard","href":"/customer/dashboard","icon":"","target":"_self","title":""},{"text":"Orders","href":"/customer/orders","icon":"empty","target":"_self","title":""},{"text":"Reviews","href":"/customer/reviews","icon":"empty","target":"_self","title":""},{"text":"Profile Settings","href":"/customer/settings","icon":"empty","target":"_self","title":""}]},{"text":"Rider","href":"#","icon":"","target":"_self","title":"","children":[{"text":"Dashboard","href":"/rider/dashboard","icon":"empty","target":"_self","title":""},{"text":"Orders","href":"/rider/order","icon":"empty","target":"_self","title":""},{"text":"Settings","href":"/rider/settings","icon":"empty","target":"_self","title":""}]}]',
                "lang" => "en",
                "status" => 1,
                "created_at" => "2021-12-01 18:19:55",
                "updated_at" => "2022-01-09 14:16:03"
            )
        );

        Menu::insert($menus);
    }
}
