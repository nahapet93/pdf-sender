<?php

namespace App\Http\Controllers;

use App\Events\FileSent;
use App\Mail\PdfSend;
use App\Models\File;
use App\Models\User;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index()
    {
        $file = File::first();
        return view('index', compact('file'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => [
                'required',
                \Illuminate\Validation\Rules\File::types(['pdf'])
            ]
        ]);

        if ($validator->fails()) {
            $request->session()->flash('error', 'Upload was not successful');
        } else {
            $existingFile = File::first();

            if ($existingFile) {
                $existingFile->delete();
            }

            $fileName = $request->file('file')->store('pdf_files', ['disk' => 'public']);
            File::create(['file_name' => $fileName]);
            $request->session()->flash('success', 'Upload was successful');
        }

        return redirect(route('home'));
    }

    public function send(Request $request)
    {
        $file = File::first();
        $emails = User::select('email')->whereNotNull('email')->get()->pluck('email');
        $telegramNicknames = User::select('telegram_nickname')->whereNotNull('telegram_nickname')->get()->pluck('telegram_nickname');
        $sentMessages = [];

        foreach ($emails as $recipient) {
            $sentMessage = Mail::to($recipient)->send(new PdfSend($file));

            if ($sentMessage) {
                $sentMessages[] = $sentMessage;
            }
        }

        $telegraph_bot = TelegraphBot::where('name', 'PdfSender')->first();
        $telegraph_bot->registerWebhook()->send();
        foreach ($telegramNicknames as $key => $recipient) {
            $chat = $telegraph_bot->chats()->firstOrCreate(
                ['telegraph_bot_id' => $telegraph_bot->id, 'chat_id' => $key],
                ['chat_id' => $key, 'name' => $recipient]
            );

            $sentMessage = $chat->document(Storage::path('public/pdf_files/' . $file->file_name))->send();

            if ($sentMessage) {
                $sentMessages[] = $sentMessage;
            }
        }

        if (count($sentMessages) === count($emails) + count($telegramNicknames)) {
            event(new FileSent());
        }

        return redirect(route('users'));
    }
}
