<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function seoIndex()
    {
        abort_if(!Auth()->user()->can('option'), 401);
        $data = Option::where('key', 'seo_home')->orWhere('key', "seo_blog")->orWhere('key', "seo_service")->orWhere('key', "seo_contract")->orWhere('key', "seo_pricing")->get();
        return view('admin.option.seo-index', compact('data'));
    }

    public function seoEdit($id)
    {
        abort_if(!Auth()->user()->can('option'), 401);
        $data = Option::where('id', $id)->first();
        return view('admin.option.seo-edit', compact('data'));
    }

    public function seoUpdate(Request $request, $id)
    {
        $request->validate([
            'site_name'          => 'required',
            'matatag'            => 'required',
            'twitter_site_title' => 'required',
            'matadescription'    => 'required',
        ]);

        $option = Option::where('id', $id)->first();

        $data = [
            "site_name"          => $request->site_name,
            "matatag"            => $request->matatag,
            "twitter_site_title" => $request->twitter_site_title,
            "matadescription"    => $request->matadescription,
        ];
        $value = json_encode($data);
        $option->value = $value;
        $option->save();
        return response()->json('Successfully Updated');
    }

    public function edit($key)
    {
        abort_if(!Auth()->user()->can('option'), 401);
        if ($key == 'cron_option') {
            $option = Option::where('key', $key)->first();
            $option = json_decode($option->value ?? '');

            $automatic_renew_plan_mail = Option::where('key', 'automatic_renew_plan_mail')->first();
            $automatic_renew_plan_mail = json_decode($automatic_renew_plan_mail->value ?? '');
            return view('admin.option.cron', compact('option','automatic_renew_plan_mail'));
        } else {
            $auto_enroll_after_payment = Option::where('key', 'auto_enroll_after_payment')->first();
            $tawk_to_property_id = Option::where('key', 'tawk_to_property_id')->first();
            $currency = Option::where('key', 'currency')->first();
            $tax = Option::where('key', 'tax')->first();
            $invoice_prefix = Option::where('key', 'invoice_prefix')->first();
            $support_email = Option::where('key', 'support_email')->first();

            return view('admin.option.option', compact('auto_enroll_after_payment', 'tawk_to_property_id', 'currency', 'tax', 'invoice_prefix', 'support_email'));
        }
        abort(404);

    }

    public function update(Request $request, $key)
    {
        if ($key == 'cron_option') {
            $request->validate([
                'status'              => 'required',
                'days'                => 'required',
                'assign_default_plan' => 'required',
                'alert_message'       => 'required',
                'expire_message'      => 'required',
            ]);

            $option = Option::where('key', $key)->first();

            $data = [
                "status"              => $request->status,
                "days"                => $request->days,
                "assign_default_plan" => $request->assign_default_plan,
                "alert_message"       => $request->alert_message,
                "expire_message"      => $request->expire_message,
            ];
            $value = json_encode($data);
            $option->value = $value;
            $option->save();
        } else {
            $request->validate([
                'logo'    => 'image|max:500',
                'favicon' => 'mimes:ico',

            ]);
            $auto_enroll_after_payment = Option::where('key', 'auto_enroll_after_payment')->first();
            $auto_enroll_after_payment->value = $request->auto_enroll_after_payment;
            $auto_enroll_after_payment->save();

            $tawk_to_property_id = Option::where('key', 'tawk_to_property_id')->first();
            $tawk_to_property_id->value = $request->tawk_to_property_id;
            $tawk_to_property_id->save();

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $logo = 'logo.png';
                $thum_image_path = 'uploads/';
                $file->move($thum_image_path, $logo);
            }
            if ($request->hasFile('favicon')) {
                $file = $request->file('favicon');
                $favicon = 'favicon.ico';
                $thum_image_path = 'uploads/';
                $file->move($thum_image_path, $favicon);
            }

        }

        return response()->json('Successfully Updated');

    }

    public function settingsEdit()
    {
        abort_if(!Auth()->user()->can('option'), 401);
        $theme = Option::where('key', 'theme_settings')->first();
        $currency_symbol = Option::where('key','currency_symbol')->first();
        return view('admin.option.theme', compact('theme','currency_symbol'));
    }

    public function settingsUpdate($id, Request $request)
    {
        $request->validate([
            'footer_description' => 'required',
            'newsletter_address' => 'required',
            'theme_color' => 'required',
            'new_account_button' => 'required',
            'new_account_url' => 'required',
            'new_account_button' => 'required',
            'currency_symbol' => 'required'
        ]);

        foreach ($request->social as $value) {
            $social[] = [
                'icon' => $value['icon'],
                'link' => $value['link'],
            ];
        };

        // logo check
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo_name = 'logo.png';
            $logo_path = 'uploads/';
            $logo->move($logo_path, $logo_name);

        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $favicon_name = 'favicon.ico';
            $favicon_path = 'uploads/';
            $favicon->move($favicon_path, $favicon_name);
        }

        $data = [
            'footer_description' => $request->footer_description,
            'newsletter_address' => $request->newsletter_address,
            'theme_color'        => $request->theme_color,
            'new_account_button' => $request->new_account_button,
            'new_account_url'    => $request->new_account_url,
            'social'             => $social,
        ];

        $currency_symbol = Option::where('key','currency_symbol')->first();
        if(!$currency_symbol)
        {
            $currency_symbol = new Option();
            $currency_symbol->key = 'currency_symbol';
        }
        $currency_symbol->value = $request->currency_symbol;
        $currency_symbol->save();

        $theme = Option::findOrFail($id);
        $theme->key = 'theme_settings';
        $theme->value = json_encode($data);
        $theme->save();
        return response()->json('Theme Settings Updated!!');
    }

}
