<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function store(Request $request, $sessionId)
{
    $pathImage = null;
    $pathVoice = null;

    if ($request->hasFile('image')) {
        $pathImage = $request->file('image')->store('diskusi', 'public');
    }

    if ($request->hasFile('voice')) {
        $pathVoice = $request->file('voice')->store('diskusi', 'public');
    }

    Discussion::create([
        'session_id' => $sessionId,
        'sender_id'  => auth('dosen')->id(),
        'message'    => $request->message,
        'image'      => $pathImage,   // 🔥 WAJIB ADA
        'voice'      => $pathVoice,
    ]);

    return back();
}

}
