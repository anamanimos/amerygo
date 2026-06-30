<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function global()
    {
        $keys = ['site_name', 'whatsapp_number', 'site_favicon', 'seo_title', 'seo_description', 'seo_keywords', 'site_logo_light', 'site_logo_dark', 'site_logo_sm_light', 'site_logo_sm_dark', 'limit_designs'];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

        return view('console.settings.global', compact('settings'));
    }

    public function updateGlobal(Request $request)
    {
        $keys = ['site_name', 'whatsapp_number', 'seo_title', 'seo_description', 'seo_keywords', 'limit_designs'];
        
        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
        }

        // Handle base64 logo uploads
        $logoKeys = ['site_logo_light', 'site_logo_dark', 'site_logo_sm_light', 'site_logo_sm_dark'];
        foreach ($logoKeys as $logoKey) {
            if ($request->filled($logoKey)) {
                $base64Data = $request->input($logoKey);
                
                // Cek apakah data benar-benar base64
                if (preg_match('/^data:image\/([\w+]+);base64,/', $base64Data, $type)) {
                    $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif, svg+xml

                    if (in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp', 'svg+xml'])) {
                        $base64Data = base64_decode($base64Data);

                        if ($base64Data !== false) {
                            $ext = $type === 'svg+xml' ? 'svg' : $type;
                            $filename = time() . '_' . $logoKey . '.' . $ext;
                            $path = public_path('uploads/settings/' . $filename);
                            
                            // Pastikan folder ada
                            if (!file_exists(public_path('uploads/settings'))) {
                                mkdir(public_path('uploads/settings'), 0777, true);
                            }

                            file_put_contents($path, $base64Data);
                            Setting::updateOrCreate(['key' => $logoKey], ['value' => 'uploads/settings/' . $filename]);
                        }
                    }
                }
            }
        }

        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $filename = time() . '_favicon.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => 'uploads/settings/' . $filename]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan global berhasil disimpan.']);
        }
        return redirect()->route('console.settings.global')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
